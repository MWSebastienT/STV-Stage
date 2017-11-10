<?php

namespace BackBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class SuiviController extends Controller
{
    /**
     * @Route("/suivi", name="suivi_show")
     */
    public function indexAction()
    {
        return $this->render('BackBundle:Suivi:index.html.twig');
    }
}
