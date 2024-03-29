<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @UniqueEntity(fields={"email"}, message="There is already an account with this email")
 */
class User implements UserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $email;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $firstMessagePostedAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $lastMessagePostedAt;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $totalMessage;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $firstName;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $lastName;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $isConnected;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $lastConnectedAt;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $isStudent;

    public function __construct()
    {
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getFirstMessagePostedAt(): ?\DateTimeInterface
    {
        return $this->firstMessagePostedAt;
    }

    public function setFirstMessagePostedAt(?\DateTimeInterface $firstMessagePostedAt): self
    {
        $this->firstMessagePostedAt = $firstMessagePostedAt;

        return $this;
    }

    public function getLastMessagePostedAt(): ?\DateTimeInterface
    {
        return $this->lastMessagePostedAt;
    }

    public function setLastMessagePostedAt(?\DateTimeInterface $lastMessagePostedAt): self
    {
        $this->lastMessagePostedAt = $lastMessagePostedAt;

        return $this;
    }

    public function getTotalMessage(): ?int
    {
        return $this->totalMessage;
    }

    public function setTotalMessage(?int $totalMessage): self
    {
        $this->totalMessage = $totalMessage;

        return $this;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(?string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(?string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

  

    public function getIsConnected(): ?bool
    {
        return $this->isConnected;
    }

    public function setIsConnected(?bool $isConnected): self
    {
        $this->isConnected = $isConnected;

        return $this;
    }

    public function getLastConnectedAt(): ?\DateTimeInterface
    {
        return $this->lastConnectedAt;
    }

    public function setLastConnectedAt(?\DateTimeInterface $lastConnectedAt): self
    {
        $this->lastConnectedAt = $lastConnectedAt;

        return $this;
    }

    public function getIsStudent(): ?bool
    {
        return $this->isStudent;
    }

    public function setIsStudent(?bool $isStudent): self
    {
        $this->isStudent = $isStudent;

        return $this;
    }
}
