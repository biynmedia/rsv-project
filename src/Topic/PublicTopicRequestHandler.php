<?php


namespace App\Topic;


use App\Entity\Topic;
use App\Rsv\RsvTrait;
use App\Upload\UploadManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Workflow\Registry;

class PublicTopicRequestHandler
{

    use RsvTrait;

    private $manager, $uploadManager, $workflows, $topicFactory;

    public function __construct(EntityManagerInterface $manager,
                                Registry $workflows,
                                TopicFactory $topicFactory,
                                UploadManager $uploadManager)
    {
        $this->manager = $manager;
        $this->workflows = $workflows;
        $this->uploadManager = $uploadManager;
        $this->topicFactory = $topicFactory;
    }

    public function handle(PublicTopicRequest $topicRequest)
    {
        # Generate Topic Alias
        $topicRequest->alias = $this->slugify($topicRequest->name);

        # Handle Workflow Process
        $workflow = $this->workflows->get($topicRequest);
        $workflow->apply($topicRequest, 'await');

        # Create Topic Profil
        $topic = $this->topicFactory->createFromPublicTopicRequest($topicRequest);

        # Persist data
        $this->manager->persist($topic);
        $this->manager->flush();

        # TODO : Dispatch Topic Event

        # Return user
        return $topic;
    }

    public function update(TopicRequest $topicRequest, Topic $topic)
    {
        # Generate Topic Alias
        $topicRequest->alias = $this->slugify($topicRequest->name);

        # Handle Image Upload
        # Todo delete previous images
        if($topicRequest->image) {
            $topicRequest->image = $this->uploadManager->upload($topicRequest->image, $topic->getImage());
        } else {
            $topicRequest->image = $topic->getImage();
        }

        # Create Topic Profil
        $topic->update(
            $topicRequest->name,
            $topicRequest->alias,
            $topicRequest->summary,
            $topicRequest->content,
            $topicRequest->image,
            $topicRequest->status,
            $topicRequest->category
        );

        # Persist data
        $this->manager->flush();

        # TODO : Dispatch Topic Update Event

        # Return user
        return $topic;
    }
}