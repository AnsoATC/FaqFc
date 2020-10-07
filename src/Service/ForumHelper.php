<?php

namespace App\Service;

use App\Entity\FcCategory;
use App\Entity\Message;
use App\Entity\User;
use App\Repository\FcCategoryRepository;
use App\Repository\MessageRepository;
use App\Repository\UserRepository;

class ForumHelper
{
    private $messageRepository;
    private $fcCategoryRepository;
    private $userRepository;

    public function __construct(UserRepository $userRepository, FcCategoryRepository $fcCategoryRepository,  MessageRepository $messageRepository)
    {
        $this->fcCategoryRepository = $fcCategoryRepository;
        $this->messageRepository = $messageRepository;
        $this->userRepository = $userRepository;
    }



    public function getStats()
    {
        $participants = $this->userRepository->findParticipants();
        $connectedUser = $this->userRepository->findConnectedUser();

        return [
            //Stats about category
            "category" => [
                "count" => $this->fcCategoryRepository->findCountTotal(),
            ],
            // Stat about message
            "message" => [
                "count" => $this->messageRepository->findCountTotal(),
                "noreplied" => [
                    "count" => $this->messageRepository->findCountTotalNonRepliedMessage(),
                    "list" => $this->messageRepository->findNonRepliedMessages()
                ]
            ],
            // Stats about participants
            "participants" => [
                "count" => sizeof($participants),
                "list" => $participants,
                "connected" => [
                    "count" => sizeof($connectedUser),
                    "list" => $connectedUser,
                ]
            ]
        ];
    }


    public function getCategoriesAndMessage(): ?array
    {
        $categoriesTreeview = [];
        $categories = $this->fcCategoryRepository->findAllCategories();
        foreach ($categories as $category) {
            # code...
            $newCat = [];
            $newCat["topic"] = $category;
            $newCat["lastmessages"] = $this->messageRepository->findLastMessageOfCategory($category);
            array_push($categoriesTreeview, $newCat);
        }
        // dd($categoriesTreeview);
        return $categoriesTreeview;
    }

    public function responsesListOf(Message $question): ?array
    {

        return $this->messageRepository->findResponsesOf($question);
    }

    public function isUserFirstPost(User $user): ?bool
    {
        return $this->messageRepository->findCountTotalMessageOf($user) == 0 ? true : false;
    }


    public function getParticipantsListOf(FcCategory $category): ?array
    {
        return $this->messageRepository->findParticipantsOfCategory($category);
    }

    public function getParticipantsList(): ?array
    {
        return $this->userRepository->findParticipants();
    }

    

    public function getNonRepliedMessages(): ?array
    {
        return $this->messageRepository->findNonRepliedMessages();
    }
}
