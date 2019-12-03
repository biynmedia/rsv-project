<?php


namespace App\Answer;


use App\Entity\Answer;
use App\Entity\Topic;
use App\Entity\User;
use Symfony\Component\Validator\Constraints as Assert;

class AnswerRequest
{
    public $id;

    /**
     * @Assert\NotBlank(message="N'oubliez pas de rédiger une réponse courte.")
     * @Assert\Length(max="255", maxMessage="Votre réponse ne peux pas dépasser {{ limit }} caractères.")
     */
    public $summary;
    public $content;
    public $writingDate;
    public $updatedDate;
    public $deletedDate;
    public $publishDate;
    public $topic;
    public $user;

    /**
     * AnswerRequest constructor.
     * @param Topic $topic
     * @param User $user
     */
    public function __construct(Topic $topic = null, User $user = null)
    {
        $this->topic = $topic;
        $this->user = $user;
        $this->writingDate = new \DateTime();
    }

    public static function createFromAnswer(Answer $answer): self
    {
        $answerReq = new self();
        $answerReq->id = $answer->getId();
        $answerReq->summary = $answer->getSummary();
        $answerReq->content = $answer->getContent();
        $answerReq->writingDate = $answer->getWritingDate();
        $answerReq->updatedDate = $answer->getUpdatedDate();
        $answerReq->deletedDate = $answer->getDeletedDate();
        $answerReq->publishDate = $answer->getPublishDate();
        $answerReq->topic = $answer->getTopic();
        $answerReq->user = $answer->getUser();

        return $answerReq;
    }

}