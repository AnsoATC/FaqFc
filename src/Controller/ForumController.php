<?php

namespace App\Controller;

use App\Entity\FcCategory;
use App\Entity\Message;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/forum")
 */
class ForumController extends AbstractController
{
    /**
     * Categorgy list with last messages and basic stats data
     * @Route("/forum", name="forum")
     */
    public function index()
    {
        //TODO: Fetch all category


        //For each category get it 5 last message with basics stat( viewed, reply)


        //Enable search in forum


        //Get global stat from the forum:  nb of category, nb of message, nb of participants

        //Tool bar with: create a mes message, dernier message non lu, messages sans reponse, 
        return $this->render('forum/index.html.twig', [
            'controller_name' => 'ForumController',
        ]);
    }


    /**
     * List of person who have create a post|message in a given category
     * @Route("/forum", name="forum_participant_of_category")
     */
    public function participantsOfCategory(FcCategory $fcCategory)
    {
        //Get all author
        //For each author, check if he has at least one message, if ok, push it in the array
        //For each fetched user get his last message

        return $this->render('forum/index.html.twig', [
            'controller_name' => 'ForumController',
        ]);
    }

    /**
     * List participants of a given category
     * @Route("/messageof/{id}", name="forum_message_of_author")
     */
    public function messageOfAuthor(User $user)
    {
        //Get all message of a given user

        return $this->render('forum/index.html.twig', [
            'controller_name' => 'ForumController',
        ]);
    }


    /**
     * Profile of an author
     * @Route("/author/{id}", name="forum_author")
     */
    public function author(User $user)
    {
        //Get all message of a given user

        return $this->render('forum/index.html.twig', [
            'controller_name' => 'ForumController',
        ]);
    }

    /**
     * List participants of a given category
     * @Route("/category/{id}", name="forum_message_of_category")
     */
    public function messageOfCategory(FcCategory $fcCategory)
    {
        //Get all message of a given category
        //Tool bar with: create a new message, mes message, dernier message non lu, messages sans reponse
        return $this->render('forum/index.html.twig', [
            'controller_name' => 'ForumController',
        ]);
    }

    /**
     * List participants of a given category
     * @Route("/forum", name="forum_response_of_message")
     */
    public function responseOfMessage(Message $message)
    {
        //Get a message and it responses

        //User can post a new message as response of this message
        return $this->render('forum/index.html.twig', [
            'controller_name' => 'ForumController',
        ]);
    }


    /**
     * Statistics data for the site manager about forum usage
     * @Route("/forum", name="forum_statistics")
     */
    public function statistics()
    {
        //Get stat data:
        //1. Nb of category, nb of message, most visited category, most replied message, least replied message,
        // most active user
        return $this->render('forum/index.html.twig', [
            'controller_name' => 'ForumController',
        ]);
    }
}
