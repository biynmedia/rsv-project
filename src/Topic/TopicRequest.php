<?php


namespace App\Topic;

use App\Entity\Topic;
use Symfony\Component\Asset\Packages;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraints as Assert;

class TopicRequest
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

    /**
     * @Assert\NotBlank(message="N'oubliez pas le contenu de votre sujet.")
     */
    public $content;

    /**
     * @Assert\Image(maxSize="2M",
     *     mimeTypesMessage="Vérifiez le format de votre fichier.",
     *     maxSizeMessage="Votre image est trop lourde. {{ limit }} maximum.")
     */
    public $image;
    public $imageUrl;
    public $status;
    public $user;
    public $writingDate;
    public $updatedDate;
    public $deletedDate;
    public $publishDate;

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

    public static function createFromTopic(Topic $topic, string $uploadsDir, Packages $packages): self
    {
        $topicReq = new self();
        $topicReq->user = $topic->getUser();
        $topicReq->writingDate = $topic->getWritingDate();
        $topicReq->content = $topic->getContent();
        $topicReq->summary = $topic->getSummary();
        $topicReq->updatedDate = $topic->getUpdatedDate();
        $topicReq->publishDate = $topic->getPublishDate();
        $topicReq->name = $topic->getName();
        $topicReq->alias = $topic->getAlias();
        $topicReq->image = new File($uploadsDir . '/' . $topic->getImage());
        $topicReq->imageUrl = $packages->getUrl('uploads' . '/' . $topic->getImage());
        $topicReq->category = $topic->getCategory();
        $topicReq->status = $topic->getStatus();

        return $topicReq;
    }
}