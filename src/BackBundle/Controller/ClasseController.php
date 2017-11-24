<?php

namespace BackBundle\Controller;

use BackBundle\Form\EleveType;
use ConnexionBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;

class ClasseController extends Controller
{
    /**
     * @Route("/classe.html", name="classe_show")
     *
     */
    public function indexAction(Request $request, $listClasse = null)
    {
        if ($listClasse == null) {
            $em = $this->getDoctrine()->getManager();
            $listClasse = $em->getRepository('ConnexionBundle:User')->findByRole('ROLE_ELEVE');
        }
        return $this->render('BackBundle:Classe:index.html.twig', array(
            'eleves' => $listClasse
        ));
    }
}
