<?php

namespace BackBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class EntrepriseController extends Controller
{
    /**
     * @Route("/entreprise", name="entreprise_index")
     */
    public function indexAction()
    {
        return $this->render('BackBundle:Entreprise:index.html.twig');
    }

    /**
     * @Route("/entreprise/fiche", name="entreprise_show")
     */
    public function showAction()
    {
        return $this->render('BackBundle:Entreprise:ficheEntreprise.html.twig');
    }
}
