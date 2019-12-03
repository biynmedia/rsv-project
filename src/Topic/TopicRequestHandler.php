<?php


namespace App\Topic;


use App\Rsv\RsvTrait;
use App\Upload\UploadManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Workflow\Registry;

class TopicRequestHandler
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

    public function handle(TopicRequest $topicRequest)
    {
        # Generate Topic Alias
        $topicRequest->alias = $this->slugify($topicRequest->name);

        # Handle Image Upload
        if($topicRequest->image) {
            $topicRequest->image = $this->uploadManager->upload($topicRequest->image);
        } else {
            # TODO : Pas d'images il faut gérer une image par défaut
            $topicRequest->image = 'default.jpg';
        }

        # Handle Workflow Process
        $workflow = $this->workflows->get($topicRequest);
        $workflow->apply($topicRequest, 'review');

        # Create Topic Profil
        $topic = $this->topicFactory->createFromTopicRequest($topicRequest);

        # Persist data
        $this->manager->persist($topic);
        $this->manager->flush();

        # TODO : Dispatch Topic Event

        # Return user
        return $topic;
    }
}