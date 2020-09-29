<?php


namespace App\Answer;


use App\Entity\Answer;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Workflow\Registry;

class AnswerRequestHandler
{
    private $manager;
    /**
     * @var Registry
     */
    private $workflows;

    public function __construct(EntityManagerInterface $manager, Registry $workflows)
    {
        $this->manager = $manager;
        $this->workflows = $workflows;
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

        # Handle Workflow Process
        $workflow = $this->workflows->get($answerReq->topic);
        if ($workflow->can($answerReq->topic, 'review')) {
            $workflow->apply($answerReq->topic, 'review');
        }

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