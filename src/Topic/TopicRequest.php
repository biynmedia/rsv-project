<?php


namespace App\Topic;

use Symfony\Component\Validator\Constraints as Assert;

class TopicRequest
{
    public $id;

    /**
     * @Assert\NotBlank(message="Saisissez le titre du sujet.")
     * @Assert\Length(max="180", maxMessage="Votre titre ne peux pas dépasser {{ limit }} caractères.")
     */
    public $name;
    public $alias;
    public $category;

    /**
     * @Assert\NotBlank(message="Rédigez une accroche.")
     * @Assert\Length(max="255", maxMessage="Votre accroche ne peux pas dépasser {{ limit }} caractères.")
     */
    public $summary;

    /**
     * @Assert\NotBlank(message="N'oubliez pas le contenu de votre sujet.")
     */
    public $content;

    /**
     * @Assert\Image(maxSize="2M",
     *     mimeTypesMessage="Vérifiez le format de votre fichier.",
     *     maxSizeMessage="Votre image est trop lourde. {{ limit }} maximum.")
     */
    public $image;
    public $status;
    public $user;
    public $writingDate;
    public $updatedDate;
    public $deletedDate;
    public $publishDate;

    public function __construct()
    {
        $this->writingDate = new \DateTime();
    }

    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param mixed $status
     */
    public function setStatus($status): void
    {
        $this->status = $status;
    }
}