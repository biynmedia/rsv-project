<?php

namespace App\Entity;

use App\Repository\BibleBookRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=BibleBookRepository::class)
 */
class BibleBook
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="bigint", name="book_number")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=5)
     */
    private $shortName;

    /**
     * @ORM\Column(type="string", length=80)
     */
    private $longName;

    /**
     * @ORM\Column(type="string", length=10)
     */
    private $bookColor;

    /**
     * @ORM\Column(type="bigint")
     */
    private $sortingOrder;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getShortName(): ?string
    {
        return $this->shortName;
    }

    public function setShortName(string $shortName): self
    {
        $this->shortName = $shortName;

        return $this;
    }

    public function getLongName(): ?string
    {
        return $this->longName;
    }

    public function setLongName(string $longName): self
    {
        $this->longName = $longName;

        return $this;
    }

    public function getBookColor(): ?string
    {
        return $this->bookColor;
    }

    public function setBookColor(string $bookColor): self
    {
        $this->bookColor = $bookColor;

        return $this;
    }

    public function getSortingOrder(): ?string
    {
        return $this->sortingOrder;
    }

    public function setSortingOrder(string $sortingOrder): self
    {
        $this->sortingOrder = $sortingOrder;

        return $this;
    }
}
