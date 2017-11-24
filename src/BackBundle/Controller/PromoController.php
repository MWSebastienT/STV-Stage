<?php

namespace BackBundle\Controller;

use BackBundle\Entity\Promo;
use BackBundle\Form\EleveType;
use BackBundle\Form\PromoType;
use ConnexionBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;

class PromoController extends Controller
{
    /**
     * @Route("/promo.html", name="promo_show")
     *
     */
    public function indexAction(Request $request, $promos= null)
    {
        if ($promos == null) {
            $em = $this->getDoctrine()->getManager();
            $promos = $em->getRepository('BackBundle:Promo')->findAll();
        }
        return $this->render('BackBundle:Promo:index.html.twig', array(
            'promos' => $promos
        ));
    }

    /**
     * @Route("/promo.html/edit/{id}", name="promo_edit")
     */
    public function editAction(Request $request, $id)
    {
        /* Config nécessaire au fonctionnement du service */

        $em = $this->getDoctrine()->getManager();
        $promo = $em->getRepository('BackBundle:Promo')->find($id);
        $form = $this->createForm(PromoType::class, $promo);
        $entityName = 'Promo';
        $listPromo = $em->getRepository('BackBundle:Promo')->findAll();

        /* l'appel du service */

        $data = $this->container->get('back.method.actions')->formAction($request, $form, $promo, $entityName);
        if ($data[0] == 'validate') // si on est dans la validation du formulaire
        {
            $session = new Session();
            $session->getFlashBag()->add('promoModif', '');// le message à l'utilisateur
            return $this->redirectToRoute('promo_show', ['promos' => $listPromo]); // pas le choix d'utiliser ce redirectToRoute pour evité le chargment d'un cache de merde !!!!
        } else {// sinon on affiche le formulaire
            return new Response($data);
        }
    }

    /**
     * @Route("/promo.html/add", name="promo_add")
     */
    public function addAction(Request $request)
    {
        /* Config nécessaire au fonctionnement du service */

        $em = $this->getDoctrine()->getManager();
        $promo = new Promo();
        $form = $this->createForm(PromoType::class, $promo);
        $entityName = 'Promo';
        $listPromo = $em->getRepository('BackBundle:Promo')->findAll();
        $action = 'edit';

        /* l'appel du service */

        $data = $this->container->get('back.method.actions')->formAction($request, $form, $promo, $entityName, $action);// true parce que j'utilise la table User pour add
        if ($data[0] == 'validate') // si on est dans la validation du formulaire
        {
            $session = new Session();
            $session->getFlashBag()->add('promoOk', ''); // le message à l'utilisateur
            return $this->redirectToRoute('promo_show', ['promos' => $listPromo]); // pas le choix d'utiliser ce redirectToRoute pour evité le chargment d'un cache de merde !!!!
        } else {// sinon on affiche le formulaire
            return new Response($data);
        }
    }

    /**
     * @Route("/promo.html/remove/{id}", name="promo_remove")
     */
    public function removeAction($id)
    {
        /* config service */

        $em = $this->getDoctrine()->getManager();
        $promo = $em->getRepository('BackBundle:Promo')->find($id);
        $listPromo = $em->getRepository('BackBundle:Promo')->findAll();

        /* appel service */

        $this->container->get('back.method.actions')->removeAction($promo);
        $session = new Session();
        $session->getFlashBag()->add('promoDelete', '');


        return $this->redirectToRoute('promo_show', ['promos' => $listPromo]);
    }
}
