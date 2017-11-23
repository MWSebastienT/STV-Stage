<?php

namespace BackBundle\Controller;

use BackBundle\Entity\Stage;
use BackBundle\Form\StageType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
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
        $form = $this->createForm(StageType::class, $stage);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($stage);
            $em->flush();
            $session = new Session();
            $session->getFlashBag()->add('stageOk', 'Stage ajouté avec succès !');

            return $this->redirectToRoute('stage_show', ['id' => $stage->getId()]);
        }

        return $this->render('BackBundle:Stage:index.html.twig', [
            'form'        => $form->createView(),
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
     * @Route("/stage/show", name="stage_show_fiche")
     */
    public function showAction()
    {
        return $this->render('BackBundle:Stage:ficheStage.html.twig');
    }
}
