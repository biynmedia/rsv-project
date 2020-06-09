<?php

namespace App\Entity;

use App\Repository\BibleVerseRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=BibleVerseRepository::class)
 */
class BibleVerse
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="bigint")
     */
    private $id;

    /**
     * @ORM\Column(type="bigint")
     */
    private $bookNumber;

    /**
     * @ORM\Column(type="bigint")
     */
    private $chapter;

    /**
     * @ORM\Column(type="bigint")
     */
    private $verse;

    /**
     * @ORM\Column(type="text")
     */
    private $text;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getChapter(): ?int
    {
        return $this->chapter;
    }

    public function setChapter(int $chapter): self
    {
        $this->chapter = $chapter;

        return $this;
    }

    public function getVerse(): ?int
    {
        return $this->verse;
    }

    public function setVerse(int $verse): self
    {
        $this->verse = $verse;

        return $this;
    }

    public function getText(): ?string
    {
        return $this->text;
    }

    public function setText(string $text): self
    {
        $this->text = $text;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getBookNumber()
    {
        return $this->bookNumber;
    }

    /**
     * @param mixed $bookNumber
     */
    public function setBookNumber($bookNumber): void
    {
        $this->bookNumber = $bookNumber;
    }
}
