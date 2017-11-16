<?php

namespace BackBundle\Controller;

use BackBundle\Entity\Entreprise;
use BackBundle\Form\EntrepriseType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

class EntrepriseController extends Controller
{
    /**
     * @Route("/entreprise", name="entreprise_index")
     */
    public function indexAction(Request $request)
    {
        $entreprise = new Entreprise();
        $form = $this->get('form.factory')->create(EntrepriseType::class, $entreprise);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entreprise);
            $em->flush();
            return $this->redirectToRoute('entreprise_index', array('id' => $entreprise->getId()));
        }
        return $this->render('BackBundle:Entreprise:index.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * @Route("/entreprise/fiche", name="entreprise_show")
     */
    public function showAction()
    {
        return $this->render('BackBundle:Entreprise:ficheEntreprise.html.twig');
    }
}
