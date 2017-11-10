<?php

namespace BackBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class EntrepriseController extends Controller
{
    /**
     * @Route("/entreprise", name="entreprise_show")
     */
    public function indexAction()
    {
        return $this->render('BackBundle:Entreprise:index.html.twig');
    }
}
