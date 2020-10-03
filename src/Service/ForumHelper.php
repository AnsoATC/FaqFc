<?php

namespace App\Service;

use App\Repository\FcCategoryRepository;
use App\Repository\MessageRepository;
use App\Repository\MessageTreeviewRepository;
use App\Repository\UserRepository;

class ForumHelper
{
    private $messageRepository;
    private $fcCategoryRepository;
    private $messageTreeviewRepository;
    private $userRepository;

    public function __construct(UserRepository $userRepository, FcCategoryRepository $fcCategoryRepository, MessageTreeviewRepository $messageTreeviewRepository, MessageRepository $messageRepository)
    {
        $this->fcCategoryRepository = $fcCategoryRepository;
        $this->messageRepository = $messageRepository;
        $this->messageTreeviewRepository = $messageTreeviewRepository;
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
                "noreplied" => sizeof($this->messageTreeviewRepository->findUnrepliedMessages())
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

    public function getMessagesWithNoResponsesList(): ?array
    {

        return $this->messageTreeviewRepository->findUnrepliedMessages();
    }
}
