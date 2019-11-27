<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 */
class User
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=80)
     */
    private $firstname;

    /**
     * @ORM\Column(type="string", length=80)
     */
    private $lastname;

    /**
     * @ORM\Column(type="string", length=80)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $password;

    /**
     * @ORM\Column(type="array")
     */
    private $roles = [];

    /**
     * @ORM\Column(type="datetime")
     */
    private $registrationDate;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $lastConnectionDate;

    /**
     * @ORM\Column(type="string", length=20, nullable=true)
     */
    private $lastConnectionIp;

    /**
     * @ORM\Column(type="boolean")
     */
    private $receiveNotification;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Topic", mappedBy="user")
     */
    private $suggestedTopics;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Answer", mappedBy="user")
     */
    private $answers;

    public function __construct()
    {
        $this->suggestedTopics = new ArrayCollection();
        $this->answers = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
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

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getRoles(): ?array
    {
        return $this->roles;
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    public function getRegistrationDate(): ?\DateTimeInterface
    {
        return $this->registrationDate;
    }

    public function setRegistrationDate(\DateTimeInterface $registrationDate): self
    {
        $this->registrationDate = $registrationDate;

        return $this;
    }

    public function getLastConnectionDate(): ?\DateTimeInterface
    {
        return $this->lastConnectionDate;
    }

    public function setLastConnectionDate(\DateTimeInterface $lastConnectionDate): self
    {
        $this->lastConnectionDate = $lastConnectionDate;

        return $this;
    }

    public function getLastConnectionIp(): ?string
    {
        return $this->lastConnectionIp;
    }

    public function setLastConnectionIp(?string $lastConnectionIp): self
    {
        $this->lastConnectionIp = $lastConnectionIp;

        return $this;
    }

    public function getReceiveNotification(): ?bool
    {
        return $this->receiveNotification;
    }

    public function setReceiveNotification(bool $receiveNotification): self
    {
        $this->receiveNotification = $receiveNotification;

        return $this;
    }

    /**
     * @return Collection|Topic[]
     */
    public function getSuggestedTopics(): Collection
    {
        return $this->suggestedTopics;
    }

    public function addSuggestedTopic(Topic $suggestedTopic): self
    {
        if (!$this->suggestedTopics->contains($suggestedTopic)) {
            $this->suggestedTopics[] = $suggestedTopic;
            $suggestedTopic->setUser($this);
        }

        return $this;
    }

    public function removeSuggestedTopic(Topic $suggestedTopic): self
    {
        if ($this->suggestedTopics->contains($suggestedTopic)) {
            $this->suggestedTopics->removeElement($suggestedTopic);
            // set the owning side to null (unless already changed)
            if ($suggestedTopic->getUser() === $this) {
                $suggestedTopic->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Answer[]
     */
    public function getAnswers(): Collection
    {
        return $this->answers;
    }

    public function addAnswer(Answer $answer): self
    {
        if (!$this->answers->contains($answer)) {
            $this->answers[] = $answer;
            $answer->setUser($this);
        }

        return $this;
    }

    public function removeAnswer(Answer $answer): self
    {
        if ($this->answers->contains($answer)) {
            $this->answers->removeElement($answer);
            // set the owning side to null (unless already changed)
            if ($answer->getUser() === $this) {
                $answer->setUser(null);
            }
        }

        return $this;
    }
}
