<?php

namespace App\Controller;

use App\Entity\FcCategory;
use App\Entity\Message;
use App\Entity\User;
use App\Form\MessageFromCategoryType;
use App\Form\MessageType;
use App\Repository\MessageRepository;
use App\Service\ForumHelper;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/forum")
 */
class ForumController extends AbstractController
{
    /**
     * Categorgy list with last messages and basic stats data
     * @Route("/", name="forum_index")
     */
    public function index(ForumHelper $forumHelper)
    {
        return $this->render('forum/index.html.twig', [
            'categorytree' => $forumHelper->getCategoriesAndMessage(),
            'stats' => $forumHelper->getStats()
        ]);
    }



    /**
     * @Route("/new", name="forum_message_new", methods={"GET","POST"})
     */
    public function newMessage(Request $request, ForumHelper $forumHelper): Response
    {
        $user = $this->getUser();
        $message = new Message();
        $form = $this->createForm(MessageType::class, $message);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            //Save ne message in db
            $message->setPublishedAt(new \DateTime());
            $message->setReplies(0);
            $message->setResponses(null);
            $message->setIsResponse(false);;
            $message->setUser($this->getUser());
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($message);
            $entityManager->flush();

            //Update the poster
            if ($forumHelper->isUserFirstPost($user)) {
                $user->setFirstMessagePostedAt(new \DateTime());
            }
            $user->setLastMessagePostedAt(new \DateTime());
            $user->setTotalMessage($user->getTotalMessage() + 1);
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('forum_message_of_category', [
                "id" => $message->getCategory()->getId(),
            ]);
        }

        return $this->render('forum/message/new.html.twig', [
            'message' => $message,
            'form' => $form->createView(),
        ]);
    }


    /**
     * List of person who have create a post|message in a given category
     * @Route("/authorsof/?messagecategory={id}", name="forum_participant_of_category")
     */
    public function participantsOfCategory(FcCategory $fcCategory, ForumHelper $forumHelper)
    {
        if (!$fcCategory) {
            throw $this->createNotFoundException(
                'Aucun categorie retrouvé avec cet id:  ' . $fcCategory->getId()
            );
        }

        return $this->render('forum/participant_of_category.html.twig', [
            'participants' => $forumHelper->getParticipantsListOf($fcCategory)
        ]);
    }

    /**
     * List message of an user
     * @Route("/messageof/user={id}", name="forum_message_of_author")
     */
    public function messageOfAuthor(User $user, MessageRepository $messageRepository)
    {
        if (!$user) {
            throw $this->createNotFoundException(
                'Aucun utilisateur retrouvé avec cet id:  '
            );
        }

        return $this->render('forum/message_of_author.html.twig', [
            'messages' => $messageRepository->findBy([
                "user" => $user
            ]),
            'user' => $user
        ]);
    }


    /**
     * List messages of a given category
     * @Route("/messageof/category={id}", name="forum_message_of_category")
     */
    public function messageOfCategory(FcCategory $fcCategory, MessageRepository $messageRepository)
    {
        if (!$fcCategory) {
            throw $this->createNotFoundException(
                'Aucun categorie retrouvé avec cet id:  ' . $fcCategory->getId()
            );
        }

        return $this->render('forum/message_of_category.html.twig', [
            'messages' => $messageRepository->findBy([
                "category" => $fcCategory
            ]),
            'category' => $fcCategory
        ]);
    }



    /**
     * List responses of a given message
     * @Route("/message/{id}", name="forum_response_of_message", methods={"GET","POST"})
     */
    public function responseOfMessage(Message $message, Request $request, ForumHelper $forumHelper)
    {
        //If no message with this id, throw 404 error
        if (!$message) {
            throw $this->createNotFoundException(
                'Aucun message retrouvé avec cet id:  ' . $message->getId()
            );
        }


        ////////
        //Setting some variables
        $user = $this->getUser();
        $userId = $user->getId();
        $messageNeedToBeUpdate = false;



        //////////
        //Update viewed and viewedBy field if the current user hasn't seen yet this message
        if ($message->getViewedBy() == null or !in_array($userId, $message->getViewedBy())) {
            //Only update viewedby when user never see this message
            $messageViewedBy = (array) $message->getViewedBy();
            array_push($messageViewedBy, $userId);
            $message->setViewedBy($messageViewedBy);
            $message->setViewed($message->getViewed() + 1);
            $messageNeedToBeUpdate = true;
        }



        ///////
        //Prepare to handle new response for this message
        $responseMessage = new Message();
        $form = $this->createForm(MessageFromCategoryType::class, $responseMessage);
        $form->handleRequest($request);
        //em
        $entityManager = $this->getDoctrine()->getManager();

        if ($form->isSubmitted() && $form->isValid()) {

            //Save the newer response
            $responseMessage->setPublishedAt(new \DateTime());
            $responseMessage->setReplies(0);
            $responseMessage->setViewed(0);
            //Setting mean that this message is known as a response
            $responseMessage->setIsResponse(true);
            $responseMessage->setUser($user);
            $responseMessage->setCategory($message->getCategory());
            $entityManager->persist($responseMessage);
            $entityManager->flush();


            //Update the poster
            if ($forumHelper->isUserFirstPost($user)) {
                $user->setFirstMessagePostedAt(new \DateTime());
            }
            $user->setLastMessagePostedAt(new \DateTime());
            $user->setTotalMessage($user->getTotalMessage() + 1);
            $entityManager->persist($user);
            $entityManager->flush();

            //Update the original message
            $responses = (array) $message->getResponses();
            $newResponseId = $responseMessage->getId();
            array_push($responses, $newResponseId);
            $message->setResponses($responses);
            //Only update replies and repliedby of this message only now
            if ($message->getRepliedBy() == null or !in_array($userId, $message->getRepliedBy())) {
                $messageRepliedBy = (array) $message->getRepliedBy();
                array_push($messageRepliedBy, $userId);
                $message->setReplies($message->getReplies() + 1);
            }
            $messageNeedToBeUpdate = true;
        }


        //If  $messageNeedToBeUpdate, update message in db
        if ($messageNeedToBeUpdate) {
            $entityManager->persist($message);
            $entityManager->flush();
        }


        //Get this messsages responses
        if ($message->getResponses() == null or  sizeof($message->getResponses()) < 1) {
            $responses = [];
        } else {
            $responses = $forumHelper->responsesListOf($message);
        }


        //User can post a new message as response of this message
        return $this->render('forum/response_of_message.html.twig', [
            'message' => $message,
            'responses' => $responses,
            'form' => $form->createView(),
        ]);
    }


    /**
     * List messages with no replies 
     * @Route("/nonreplied", name="forum_message_without_response")
     */
    public function messageWithNoReplies(ForumHelper $forumHelper)
    {
        return $this->render('forum/message_without_response.html.twig', [
            'messages' => $forumHelper->getNonRepliedMessages(),
        ]);
    }
}
