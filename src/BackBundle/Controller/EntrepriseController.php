<?php

namespace BackBundle\Controller;

use BackBundle\Entity\Entreprise;
use BackBundle\Entity\typeEntreprise;
use ConnexionBundle\Entity\User;
use BackBundle\Form\EntrepriseType;
use ConnexionBundle\Form\RefProType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;

class EntrepriseController extends Controller
{
    /**
     * @Route("/entreprise", name="entreprise_index")
     */
    public function indexAction(Request $request)
    {
        $entreprise = new Entreprise();
        $em = $this->getDoctrine()->getManager();
        $listeEntreprise = $em->getRepository('BackBundle:Entreprise')->findAll();
        $form = $this->createForm(EntrepriseType::class, $entreprise);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($entreprise);
            $em->flush();
            $session = new Session();
            $session->getFlashBag()->add('entrepriseOk', 'Entreprise ajouté avec succès !');

            return $this->redirectToRoute('entreprise_index', ['id' => $entreprise->getId()]);
        }

        return $this->render('BackBundle:Entreprise:index.html.twig', [
            'form'        => $form->createView(),
            'entreprises' => $listeEntreprise,
        ]);
    }

    /**
     * @Route("/entreprise/fiche/{id}", name="entreprise_show")
     */
    public function showAction($id, Request $request)
    {
        $entreprise = new Entreprise();
        $refPro = new User();
        $em = $this->getDoctrine()->getManager();
        $entreprise = $em->getRepository('BackBundle:Entreprise')->find($id);
//        Je ne peux pas les afficher
        $form = $this->get('form.factory')->create(RefProType::class, $refPro);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($refPro);
            $em->flush();
            $session = new Session();
            $session->getFlashBag()->add('refProOk', 'Referent ajouté avec succès !');

            return $this->redirectToRoute('entreprise_show', ['id' => $entreprise->getId()]);
        }


        return $this->render('BackBundle:Entreprise:ficheEntreprise.html.twig', [
            'form'       => $form->createView(),
            'entreprise' => $entreprise,
        ]);
    }

    /**
     * @Route("/entreprise/delete/{id}", name="entreprise_delete")
     */
    public function deleteAction($id, Request $request)
    {
        $entreprise = new Entreprise();
        $em = $this->getDoctrine()->getManager();
        $entreprise = $em->getRepository('BackBundle:Entreprise')->find($id);
        $em->remove($entreprise);
        $em->flush();


        $entreprise = new Entreprise();
        $em = $this->getDoctrine()->getManager();
        $listeEntreprise = $em->getRepository('BackBundle:Entreprise')->findAll();
        $form = $this->createForm(EntrepriseType::class, $entreprise);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($entreprise);
            $em->flush();
            $session = new Session();
            $session->getFlashBag()->add('entrepriseOk', 'Entreprise ajouté avec succès !');

            return $this->redirectToRoute('entreprise_index', ['id' => $entreprise->getId()]);
        }

        return $this->render('BackBundle:Entreprise:index.html.twig', [
            'form'        => $form->createView(),
            'entreprises' => $listeEntreprise,
        ]);
    }
}
