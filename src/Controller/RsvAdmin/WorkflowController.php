<?php


namespace App\Controller\RsvAdmin;


use App\Entity\Topic;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Workflow\Exception\LogicException;
use Symfony\Component\Workflow\Registry;

/**
 * Class WorkflowController
 * @package App\Controller\RsvAdmin
 * @Route("/workflow")
 */
class WorkflowController extends AbstractController
{
    /**
     * Update Topic Workflow Status
     * @Route("/topic/{status<[a-zA-Z0-9\-_\/]+>}/{id<\d+>}",
     *     name="workflow_topic", methods={"GET"})
     * @Security("is_granted('ROLE_MINISTRY')")
     * @param Topic $topic
     * @param string $status
     * @param Registry $registry
     * @return RedirectResponse
     */
    public function updateTopicStatus(Topic $topic, string $status, Registry $registry)
    {
        # Get topic current workflow
        $workflow = $registry->get($topic);

        try {

            # Status change
            $workflow->apply($topic, $status);

            # Update $topic publish date
            if($status == 'publish' || $status == 'online') {
                $topic->setPublishDate();
            }

            # Persist Data
            $em = $this->getDoctrine()->getManager();
            $em->flush();

            # Flash Notification
            $this->addFlash('notice',
                'Votre demande de publication a bien été prise en compte.');

            # TODO : Ecouter les evenements du workflow pour déclencher des notifications aux ADMIN.
            # TODO : Réfléchir a la gestion en cas de refus de la publication comme un nouvelle onglet. Privé entre Admin et Eclairage. Nouveau Type Enum admin par ex.

        } catch (LogicException $e) {
            # Not allowed Transition
            $this->addFlash('error',
                'Votre demande ne peux aboutir. Contactez un administrateur.');
        }

        # Redirect
        return $this->redirectToRoute('admin_topic', [ 'alias' => $topic->getAlias(), 'id' => $topic->getId() ]);
    }
}