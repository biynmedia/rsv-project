<?php


namespace App\Topic;

use Symfony\Component\Validator\Constraints as Assert;

class PublicTopicRequest
{
    public $id;

    /**
     * @Assert\NotBlank(message="Saisissez votre question.")
     * @Assert\Length(max="180", maxMessage="Votre question ne peux pas dépasser {{ limit }} caractères.")
     */
    public $name;
    public $alias;
    public $userFirstName;
    public $userNotificationEmail;
    public $status;
    public $writingDate;

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