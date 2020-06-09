<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CommentRepository")
 */
class Comment
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180)
     */
    private $content;

    /**
     * @ORM\Column(type="datetime")
     */
    private $writingDate;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Topic", inversedBy="comments")
     * @ORM\JoinColumn(nullable=false)
     */
    private $topic;

    /**
     * @ORM\Column(type="enumcomment", length=80)
     */
    private $type;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $verse;

    public function __construct()
    {
        $this->writingDate = new \DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getWritingDate(): ?\DateTimeInterface
    {
        return $this->writingDate;
    }

    public function setWritingDate(\DateTimeInterface $writingDate): self
    {
        $this->writingDate = $writingDate;

        return $this;
    }

    public function getTopic(): ?Topic
    {
        return $this->topic;
    }

    public function setTopic(?Topic $topic): self
    {
        $this->topic = $topic;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?UserInterface $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getVerse(): ?string
    {
        return $this->verse;
    }

    public function setVerse(?string $verse): self
    {
        $this->verse = $verse;

        return $this;
    }

}
