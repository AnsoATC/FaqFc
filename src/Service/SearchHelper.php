<?php

namespace App\Service;

use App\Repository\FaqRepository;
use App\Repository\MessageRepository;

class SearchHelper
{
    private $messageRepository;
    private $faqRepository;
    private $faqFoundResultCount;
    private $faqFoundResultArray;
    private $fcFoundResultCount;
    private $fcFoundResultArray;

    public function __construct(FaqRepository $faqRepository, MessageRepository $messageRepository)
    {
        $this->faqRepository = $faqRepository;
        $this->messageRepository = $messageRepository;
        $this->faqFoundResultArray = [];
        $this->faqFoundResultCount = 0;
        $this->fcFoundResultArray = [];
        $this->fcFoundResultCount = 0;
    }





    public function fromFcAndFaq($question)
    {
        $this->faqFoundResultArray = $this->faqRepository->search($question);
        $this->fcFoundResultArray = $this->messageRepository->search($question);
        $this->faqFoundResultCount = sizeof($this->faqFoundResultArray);
        $this->fcFoundResultCount = sizeof($this->fcFoundResultArray);
    }

    public function search($question)
    {
        //Invoke search
        $this->fromFcAndFaq($question);

        //return result
        return [
            "fromFaq" => [
                "count" => $this->faqFoundResultCount,
                "list" => $this->faqFoundResultArray,
            ],
            "fromFc" => [
                "count" => $this->fcFoundResultCount,
                "list" => $this->fcFoundResultArray,
            ],
        ];
    }
}
