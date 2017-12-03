<?php

namespace BackBundle\Controller;

use BackBundle\Entity\Stage;
use BackBundle\Form\StageType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;

class StageController extends Controller
{
    /**
     * @Route("/stage", name="stage_show")
     */
    public function indexAction(Request $request)
    {
        $stage = new Stage();
        $em = $this->getDoctrine()->getManager();
        $listeStages = $em->getRepository('BackBundle:Stage')->findAll();
        $em = $this->getDoctrine()->getManager();

        $listeStages = $em->getRepository('BackBundle:Stage')->findAll();

        return $this->render('BackBundle:Stage:index.html.twig', [
            'stages' => $listeStages,
        ]);

    }

     /**
     * @Route("/stage/show", name="stage_show_fiche")
     */
    public function showAction()
    {
        return $this->render('BackBundle:Stage:ficheStage.html.twig');
    }

    /**
     * @Route("/stage/edit/{id}", name="stage_edit")
     */
    public function editAction(Request $request, $id)
    {
        /* Config nécessaire au fonctionnement du service */

        $em = $this->getDoctrine()->getManager();
        $stage = $em->getRepository('BackBundle:Stage')->find($id);
        $form = $this->createForm(StageType::class, $stage);
        $entityName = 'Stage';
        $listStage = $em->getRepository('BackBundle:Stage')->findAll();

        /* l'appel du service */

        $data = $this->container->get('back.method.actions')->formAction($request, $form, $stage, $entityName);
        if ($data[0] == 'validate') // si on est dans la validation du formulaire
        {
            $session = new Session();
            $session->getFlashBag()->add('stageModif', '');// le message à l'utilisateur

            return $this->redirectToRoute('stage_show', ['stages' => $listStage]); // pas le choix d'utiliser ce redirectToRoute pour evité le chargment d'un cache de merde !!!!
        } else {// sinon on affiche le formulaire
            return new Response($data);
        }
    }

    /**
     * @Route("/stage/add", name="stage_add")
     */
    public function addAction(Request $request)
    {
        /* Config nécessaire au fonctionnement du service */

        $em = $this->getDoctrine()->getManager();
        $stage = new Stage();
        $form = $this->createForm(StageType::class, $stage);
        $entityName = 'Stage';
        $listStage = $em->getRepository('BackBundle:Stage')->findAll();
        $action = 'edit';

        /* l'appel du service */

        $data = $this->container->get('back.method.actions')->formAction($request, $form, $stage, $entityName,null,$action);
        if ($data[0] == 'validate') // si on est dans la validation du formulaire
        {
            $session = new Session();
            $session->getFlashBag()->add('stageOk', ''); // le message à l'utilisateur
            return $this->redirectToRoute('stage_show', ['stages' => $listStage]); // pas le choix d'utiliser ce redirectToRoute pour evité le chargment d'un cache de merde !!!!
        } else {// sinon on affiche le formulaire
            return new Response($data);
        }
    }

    /**
     * @Route("/stage/remove/{id}", name="stage_remove")
     */
    public function removeAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $stage = $em->getRepository('BackBundle:Stage')->find($id);
        $this->container->get('back.method.actions')->removeAction($stage);
        $listStage = $em->getRepository('BackBundle:Stage')->findAll();
        $session = new Session();
        $session->getFlashBag()->add('stageDeleteOk', ''); // le message à l'utilisateur
        return $this->redirectToRoute('stage_show',['stage' => $listStage]);
    }

}
