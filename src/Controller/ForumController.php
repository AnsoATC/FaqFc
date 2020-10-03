<?php

namespace App\Controller;

use App\Entity\FcCategory;
use App\Entity\Message;
use App\Entity\User;
use App\Repository\MessageRepository;
use App\Service\ForumHelper;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
     * List of person who have create a post|message in a given category
     * @Route("/forum", name="forum_participant_of_category")
     */
    public function participantsOfCategory(FcCategory $fcCategory)
    {
        return $this->render('forum/participant_of_category.html.twig', [
            'controller_name' => 'ForumController',
        ]);
    }

    /**
     * List message an user
     * @Route("/messageof/{id}", name="forum_message_of_author")
     */
    public function messageOfAuthor(User $user, MessageRepository $messageRepository)
    {
        if (!$user) {
            throw $this->createNotFoundException(
                'Aucun utilisateur retrouvé avec cet id:  ' . $user->getId()
            );
        }

        return $this->render('forum/message_of_author.html.twig', [
            'messages' => $messageRepository->findBy([
                "user" => $user
            ]),
            'user'=>$user
        ]);
    }


    /**
     * List messages of a given category
     * @Route("/category/{id}", name="forum_message_of_category")
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
            'category'=>$fcCategory
        ]);
    }

    /**
     * List responses of a given message
     * @Route("/message/{id}", name="forum_response_of_message")
     */
    public function responseOfMessage(Message $message)
    {
        //Get a message and it responses

        //User can post a new message as response of this message
        return $this->render('forum/response_of_message.html.twig', [
            'controller_name' => 'ForumController',
        ]);
    }


    /**
     * List messages with no replies 
     * @Route("/nonreplied", name="forum_message_without_response")
     */
    public function messageWithNoReplies(ForumHelper $forumHelper)
    {
        return $this->render('forum/message_without_response.html.twig', [
            'messages' => $forumHelper->getMessagesWithNoResponsesList(),
        ]);
    }
}
