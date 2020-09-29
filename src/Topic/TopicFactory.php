<?php


namespace App\Topic;


use App\Entity\Topic;

class TopicFactory
{
    /**
     * Transform TopicRequest into Topic
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

    /**
     * Transform PublicTopicRequest into Topic
     * @param PublicTopicRequest $req
     * @return Topic
     */
    public function createFromPublicTopicRequest(PublicTopicRequest $req): Topic
    {
        $topic = new Topic();
        $topic->setName($req->name)
            ->setAlias($req->alias)
            ->setUserFirstname($req->userFirstName)
            ->setUserNotificationEmail($req->userNotificationEmail)
            ->setStatus($req->status)
            ->setImage('default.png')
            ->setWritingDate($req->writingDate);

        return $topic;
    }
}