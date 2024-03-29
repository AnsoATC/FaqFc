<?php

namespace App\Entity;

use App\Repository\MessageRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=MessageRepository::class)
 */
class Message
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
    private $title;

    /**
     * @ORM\Column(type="text")
     */
    private $content;

    /**
     * @ORM\Column(type="datetime")
     */
    private $publishedAt;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $viewed;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $replies;

  

    /**
     * @ORM\ManyToOne(targetEntity=User::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity=FcCategory::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $category;

    /**
     * @ORM\Column(type="array", nullable=true)
     */
    private $repliedBy = [];

    /**
     * @ORM\Column(type="array", nullable=true)
     */
    private $viewedBy = [];

    /**
     * @ORM\Column(type="array", nullable=true)
     */
    private $responses = [];

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $isResponse;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getPublishedAt(): ?\DateTimeInterface
    {
        return $this->publishedAt;
    }

    public function setPublishedAt(\DateTimeInterface $publishedAt): self
    {
        $this->publishedAt = $publishedAt;

        return $this;
    }

    public function getViewed(): ?int
    {
        return $this->viewed;
    }

    public function setViewed(?int $viewed): self
    {
        $this->viewed = $viewed;

        return $this;
    }

    public function getReplies(): ?int
    {
        return $this->replies;
    }

    public function setReplies(?int $replies): self
    {
        $this->replies = $replies;

        return $this;
    }

   

  

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getCategory(): ?FcCategory
    {
        return $this->category;
    }

    public function setCategory(?FcCategory $category): self
    {
        $this->category = $category;

        return $this;
    }

    public function getRepliedBy(): ?array
    {
        return $this->repliedBy;
    }

    public function setRepliedBy(?array $repliedBy): self
    {
        $this->repliedBy = $repliedBy;

        return $this;
    }

    public function getViewedBy(): ?array
    {
        return $this->viewedBy;
    }

    public function setViewedBy(?array $viewedBy): self
    {
        $this->viewedBy = $viewedBy;

        return $this;
    }

    public function getResponses(): ?array
    {
        return $this->responses;
    }

    public function setResponses(?array $responses): self
    {
        $this->responses = $responses;

        return $this;
    }

    public function getIsResponse(): ?bool
    {
        return $this->isResponse;
    }

    public function setIsResponse(bool $isResponse): self
    {
        $this->isResponse = $isResponse;

        return $this;
    }
 

   
}
