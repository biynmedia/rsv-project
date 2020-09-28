<?php


namespace App\Topic;


class PublicTopicRequest
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
    public $user;
    public $status;
    public $writingDate;

    public function __construct()
    {
        $this->writingDate = new \DateTime();
    }
}