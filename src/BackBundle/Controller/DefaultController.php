<?php

namespace BackBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use BackBundle\Entity\Entreprise;
use BackBundle\Entity\typeEntreprise;
use ConnexionBundle\Entity\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class DefaultController extends Controller
{
    /**
     * @Route("/",name="default_show")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $listeEntreprise = $em->getRepository('BackBundle:Entreprise')->findAll();
        $listeStages = $em->getRepository('BackBundle:Stage')->findAll();

        return $this->render('BackBundle:Default:index.html.twig', [
            'entreprises' => $listeEntreprise,
            'stages'=>$listeStages,
        ]);
    }
}
