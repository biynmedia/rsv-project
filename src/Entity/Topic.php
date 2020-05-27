<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TopicRepository")
 */
class Topic
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
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $summary;

    /**
     * @ORM\Column(type="text")
     */
    private $content;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $image;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $status;

    /**
     * @ORM\Column(type="datetime")
     */
    private $writingDate;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $updatedDate;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $deletedDate;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $publishDate;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="suggestedTopics")
     */
    private $user;

    /**
     * @ORM\Column(type="string", length=180)
     */
    private $alias;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Category", inversedBy="topics")
     * @ORM\JoinColumn(nullable=false)
     */
    private $category;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Comment", mappedBy="topic")
     */
    private $comments;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Answer", inversedBy="topic", cascade={"persist", "remove"})
     */
    private $answer;

    public function __construct()
    {
        $this->comments = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getSummary(): ?string
    {
        return $this->summary;
    }

    public function setSummary(string $summary): self
    {
        $this->summary = $summary;

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

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;

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

    public function getUpdatedDate(): ?\DateTimeInterface
    {
        return $this->updatedDate;
    }

    public function setUpdatedDate(?\DateTimeInterface $updatedDate): self
    {
        $this->updatedDate = $updatedDate;

        return $this;
    }

    public function getDeletedDate(): ?\DateTimeInterface
    {
        return $this->deletedDate;
    }

    public function setDeletedDate(?\DateTimeInterface $deletedDate): self
    {
        $this->deletedDate = $deletedDate;

        return $this;
    }

    public function getPublishDate(): ?\DateTimeInterface
    {
        return $this->publishDate;
    }

    public function setPublishDate(string $time = 'now'): self
    {
        $this->publishDate = new \DateTime($time);
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

    public function getAlias(): ?string
    {
        return $this->alias;
    }

    public function setAlias(string $alias): self
    {
        $this->alias = $alias;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

        return $this;
    }

    /**
     * @return Collection|Comment[]
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }

    public function addComment(Comment $comment): self
    {
        if (!$this->comments->contains($comment)) {
            $this->comments[] = $comment;
            $comment->setTopic($this);
        }

        return $this;
    }

    public function removeComment(Comment $comment): self
    {
        if ($this->comments->contains($comment)) {
            $this->comments->removeElement($comment);
            // set the owning side to null (unless already changed)
            if ($comment->getTopic() === $this) {
                $comment->setTopic(null);
            }
        }

        return $this;
    }

    public function getAnswer(): ?Answer
    {
        return $this->answer;
    }

    public function setAnswer(?Answer $answer): self
    {
        $this->answer = $answer;

        return $this;
    }

    /**
     * Check if passed user is the topic writer
     * @param User $user
     * @return bool
     */
    public function isWriter(?User $user = null): bool
    {
        return $user && ($user->getId() === $this->getUser()->getId());
    }

    /**
     * Update Entity Data
     * @param string $name
     * @param string $alias
     * @param string $summary
     * @param string $content
     * @param string $image
     * @param string $status
     * @param Category $category
     */
    public function update(
        string $name,
        string $alias,
        string $summary,
        string $content,
        string $image,
        string $status,
        Category $category)
    {
        $this->name = $name;
        $this->alias = $alias;
        $this->summary = $summary;
        $this->content = $content;
        $this->image = $image;
        $this->status = $status;
        $this->category = $category;
        $this->updatedDate = new \DateTime();
    }
}
