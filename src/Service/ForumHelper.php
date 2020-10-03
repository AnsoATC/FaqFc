<?php
/*
 * This file is part of the MemoireDor project.
 *
 * Author: Justin Dah-kenangnon <dah.kenangnon@gmail.com>
 * 
 * (c) WebStudyCorner
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Service;

use App\Repository\FaqRepository;
use App\Repository\MessageRepository;

class ForumHelper
{
    private $messageRepository;
    private $faqRepository;

    public function __construct(FaqRepository $faqRepository, MessageRepository $messageRepository)
    {
        $this->faqRepository = $faqRepository;
        $this->messageRepository = $messageRepository;
    }

    


}
