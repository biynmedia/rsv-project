<?php


namespace App\Topic;


use App\Entity\Topic;

class TopicFactory
{
    /**
     * Transform UserRequest into User
     * @param TopicRequest $req
     * @return Topic
     */
    public function createFromTopicRequest(TopicRequest $req): Topic
    {
        $topic = new Topic();
        $topic->setName($req->name)
            ->setAlias($req->alias)
            ->setStatus($req->status)
            ->setUser($req->user)
            ->setCategory($req->category)
            ->setContent($req->content)
            ->setImage($req->image)
            ->setSummary($req->summary)
            ->setWritingDate($req->writingDate);

        return $topic;
    }
}