<?php

namespace BackBundle\Controller;

use BackBundle\Entity\Visite;
use BackBundle\Form\VisiteType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;

class VisiteController extends Controller
{
    /**
     * @Route("/visite/add", name="visite_add")
     */
    public function addVisiteAction(Request $request)
    {

        /* Config nécessaire au fonctionnement du service */

        $em = $this->getDoctrine()->getManager();
        $visite = new Visite();
        $form = $this->createForm(VisiteType::class, $visite);
        $entityName = 'Visite';
        $listVisites = $em->getRepository('BackBundle:Visite')->findAll();
        $action = 'edit';
        $listeStages = $em->getRepository('BackBundle:Stage')->findAll();


        /* l'appel du service */
        $data = $this->container->get('back.method.actions')->formAction($request, $form, $visite, $entityName,$listVisites,$action,'Date');// true parce que j'utilise la table User pour add
        if ($data[0] == 'validate') // si on est dans la validation du formulaire
        {
            $session = new Session();
            $session->getFlashBag()->add('visiteOk', ''); // le message à l'utilisateur
            return $this->redirectToRoute('stage_show', ['stages' => $listeStages]); // pas le choix d'utiliser ce redirectToRoute pour evité le chargment d'un cache de merde !!!!
        } else {// sinon on affiche le formulaire
            return new Response($data);
        }
    }
}
