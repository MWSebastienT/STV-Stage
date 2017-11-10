<?php

namespace BackBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class StageController extends Controller
{
    /**
     * @Route("/stage", name="stage_show")
     */
    public function indexAction()
    {
        return $this->render('BackBundle:Stage:index.html.twig');
    }
}
