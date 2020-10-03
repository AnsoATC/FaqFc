<?php

namespace App\Entity;

use App\Repository\MessageTreeviewRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=MessageTreeviewRepository::class)
 */
class MessageTreeview
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToMany(targetEntity=Message::class)
     */
    private $question;

    /**
     * @ORM\Column(type="array", nullable=true)
     */
    private $answers = [];

    public function __construct()
    {
        $this->question = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection|Message[]
     */
    public function getQuestion(): Collection
    {
        return $this->question;
    }

    public function addQuestion(Message $question): self
    {
        if (!$this->question->contains($question)) {
            $this->question[] = $question;
        }

        return $this;
    }

    public function removeQuestion(Message $question): self
    {
        if ($this->question->contains($question)) {
            $this->question->removeElement($question);
        }

        return $this;
    }

    public function getAnswers(): ?array
    {
        return $this->answers;
    }

    public function setAnswers(?array $answers): self
    {
        $this->answers = $answers;

        return $this;
    }
}
