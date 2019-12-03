<?php


namespace App\Answer;


use App\Entity\Answer;
use Doctrine\ORM\EntityManagerInterface;

class AnswerRequestHandler
{
    private $manager;

    public function __construct(EntityManagerInterface $manager)
    {
        $this->manager = $manager;
    }

    public function handle(AnswerRequest $answerReq)
    {
        # Create Answer
        $answer = new Answer();
        $answer->setWritingDate($answerReq->writingDate)
            ->setSummary($answerReq->summary)
            ->setContent($answerReq->content)
            ->setUser($answerReq->user)
            ->setTopic($answerReq->topic);

        # Persist Data
        $this->manager->persist($answer);
        $this->manager->flush();

        # Return Answer
        return $answer;
    }

    public function update(AnswerRequest $answerReq, Answer $answer)
    {
        # Create Answer
        $answer->update(
            $answerReq->summary,
            $answerReq->content,
            $answerReq->user,
            $answerReq->topic,
            $answerReq->writingDate
        );

        # Persist Data
        $this->manager->flush();

        # Return Answer
        return $answer;
    }
}