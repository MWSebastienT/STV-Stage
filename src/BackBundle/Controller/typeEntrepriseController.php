<?php

namespace BackBundle\Controller;

use BackBundle\Entity\typeEntreprise;
use BackBundle\Form\typeEntrepriseType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\BrowserKit\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;

class typeEntrepriseController extends Controller
{
    /**
     * @Route("/typeentreprise", name="typeentreprise_index")
     */
    public function indexAction(Request $request)
    {
        $typeEntreprise = new typeEntreprise();
        $em = $this->getDoctrine()->getManager();
        $listeTypeEntreprise = $em->getRepository('BackBundle:typeEntreprise')->findAll();
        $em = $this->getDoctrine()->getManager();
        return $this->render('BackBundle:TypeEntreprise:index.html.twig', [
            'typeEntreprises' => $listeTypeEntreprise,
        ]);
    }

    /**
     * @Route("/typeentreprise/add", name="typeentreprise_add")
     */
    public function addAction(Request $request)
    {

        /* Config nécessaire au fonctionnement du service */

        $em = $this->getDoctrine()->getManager();
        $typeEntreprise = new typeEntreprise();
        $form = $this->createForm(typeEntrepriseType::class, $typeEntreprise);
        $entityName = 'typeEntreprise';
        $listTypeEntreprise = $em->getRepository('BackBundle:typeEntreprise')->findAll();
        $action = 'edit';

        /* l'appel du service */

        $data = $this->container->get('back.method.actions')->formAction($request, $form, $typeEntreprise, $entityName,$listTypeEntreprise, $action,'Label');// true parce que j'utilise la table User pour add
        if ($data[0] == 'validate') // si on est dans la validation du formulaire
        {


            $session = new Session();
            $session->getFlashBag()->add('typeentrepriseOk', ''); // le message à l'utilisateur
            return $this->redirectToRoute('typeentreprise_index', ['typeEntreprises' => $listTypeEntreprise]); // pas le choix d'utiliser ce redirectToRoute pour evité le chargment d'un cache de merde !!!!
        } else {// sinon on affiche le formulaire
            return new \Symfony\Component\HttpFoundation\Response($data);
        }
    }

    /**
     * @Route("/typeentreprise/edit/{id}", name="typeentreprise_edit")
     */
    public function editAction(Request $request, $id)
    {
        /* Config nécessaire au fonctionnement du service */

        $em = $this->getDoctrine()->getManager();
        $typeEntreprise = $em->getRepository('BackBundle:typeEntreprise')->find($id);
        $form = $this->createForm(typeEntrepriseType::class, $typeEntreprise);
        $entityName = 'typeEntreprise';
        $listTypeEntreprise = $em->getRepository('BackBundle:typeEntreprise')->findAll();

        /* l'appel du service */
        $data = $this->container->get('back.method.actions')->formAction($request, $form, $typeEntreprise, $entityName,$listTypeEntreprise,null,'Label');
        if ($data[0] == 'validate') // si on est dans la validation du formulaire
        {
            $session = new Session();
            $session->getFlashBag()->add('entrepriseModif', '');// le message à l'utilisateur

            return $this->redirectToRoute('typeentreprise_index', ['typeEntreprise' => $listTypeEntreprise]); // pas le choix d'utiliser ce redirectToRoute pour evité le chargment d'un cache de merde !!!!
        } else {// sinon on affiche le formulaire
            return new \Symfony\Component\HttpFoundation\Response($data);
        }
    }

    /**
     * @Route("/typeentreprise/remove/{id}", name="typeentreprise_remove")
     */
    public function removeAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $typeEntreprise = $em->getRepository('BackBundle:typeEntreprise')->find($id);
        $this->container->get('back.method.actions')->removeAction($typeEntreprise);
        $listEntreprise = $em->getRepository('BackBundle:typeEntreprise')->findAll();
        $session = new Session();
        $session->getFlashBag()->add('enterpriseDeleteOk', ''); // le message à l'utilisateur
        return $this->redirectToRoute('typeentreprise_index',['typeEntreprises' => $listEntreprise]);
    }
}
