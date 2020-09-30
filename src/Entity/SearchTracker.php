<?php

namespace App\Entity;

use App\Repository\SearchTrackerRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SearchTrackerRepository::class)
 */
class SearchTracker
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $question;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $faqFoundResult;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $fcFoundResult;

    /**
     * @ORM\Column(type="datetime")
     */
    private $searchedAt;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuestion(): ?string
    {
        return $this->question;
    }

    public function setQuestion(?string $question): self
    {
        $this->question = $question;

        return $this;
    }

    public function getFaqFoundResult(): ?int
    {
        return $this->faqFoundResult;
    }

    public function setFaqFoundResult(?int $faqFoundResult): self
    {
        $this->faqFoundResult = $faqFoundResult;

        return $this;
    }

    public function getFcFoundResult(): ?int
    {
        return $this->fcFoundResult;
    }

    public function setFcFoundResult(?int $fcFoundResult): self
    {
        $this->fcFoundResult = $fcFoundResult;

        return $this;
    }

    public function getSearchedAt(): ?\DateTimeInterface
    {
        return $this->searchedAt;
    }

    public function setSearchedAt(\DateTimeInterface $searchedAt): self
    {
        $this->searchedAt = $searchedAt;

        return $this;
    }
}
