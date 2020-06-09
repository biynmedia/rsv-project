<?php


namespace App\Comment;


use App\Comment\Dbal\EnumCommentType;
use DateTime;
use Symfony\Component\Validator\Constraints as Assert;

class CommentRequest
{
    public $id;

    /**
     * @Assert\NotBlank(message="N'oubliez pas le contenu de votre point de vue.")
     */
    public $content;
    public $writingDate;
    public $topic;
    public $type;
    public $user;
    public $book;
    public $verse;

    public function __construct()
    {
        $this->writingDate = new DateTime();
        $this->type = EnumCommentType::STATUS_PUBLIC;
    }

}