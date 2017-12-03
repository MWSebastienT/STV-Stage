<?php

namespace BackBundle\Controller;

use BackBundle\Entity\Classe;
use BackBundle\Entity\ClassePromo;
use BackBundle\Form\ClasseType;
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
    public function indexAction($listClasse = null)
    {
        if ($listClasse == null) {
            $em = $this->getDoctrine()->getManager();
            $listClasse = $em->getRepository('BackBundle:Classe')->findAll();
        }
        return $this->render('BackBundle:Classe:index.html.twig', array(
            'classes' => $listClasse
        ));
    }

    /**
     * @Route("/classe.html/show/{id}", name="classe_focus")
     *
     */
    public function showAction($listClasse = null, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $classe = $em->getRepository('BackBundle:Classe')->find($id);

        return $this->render('BackBundle:Classe:show.html.twig', array(
            'classe' => $classe
        ));
    }

    /**
     * @Route("/classe.html/edit/{id}", name="classe_edit")
     */
    public function editAction(Request $request, $id)
    {
        /* Config nécessaire au fonctionnement du service */

        $em = $this->getDoctrine()->getManager();
        $classe = $em->getRepository('BackBundle:Classe')->find($id);
        $form = $this->createForm(ClasseType::class, $classe);
        $entityName = 'Classe';
        $listClasse = $em->getRepository('BackBundle:Classe')->findAll();

        /* l'appel du service */

        $data = $this->container->get('back.method.actions')->formAction($request, $form, $classe, $entityName,$listClasse,null,'Label');
        if ($data[0] == 'validate') // si on est dans la validation du formulaire
        {
            $session = new Session();
            $session->getFlashBag()->add('classeModif', '');// le message à l'utilisateur
            return $this->redirectToRoute('classe_show', ['classes' => $listClasse]); // pas le choix d'utiliser ce redirectToRoute pour evité le chargment d'un cache de merde !!!!
        } else {// sinon on affiche le formulaire
            return new Response($data);
        }
    }

    /**
     * @Route("/classe.html/add", name="classe_add")
     */
    public function addAction(Request $request)
    {

        /* Config nécessaire au fonctionnement du service */

        $em = $this->getDoctrine()->getManager();
        $classe = new Classe();
        $form = $this->createForm(ClasseType::class, $classe);
        $entityName = 'Classe';
        $listClasse = $em->getRepository('BackBundle:Classe')->findAll();
        $action = 'edit';

        /* l'appel du service */

        $data = $this->container->get('back.method.actions')->formAction($request, $form, $classe, $entityName,$listClasse,$action,'Label');// true parce que j'utilise la table User pour add
        if ($data[0] == 'validate') // si on est dans la validation du formulaire
        {
            $lesPromo = $classe->getLesPromos();
            foreach ($lesPromo as $unePromo)
            {
                $classPromo = new ClassePromo();
                $classPromo->setClasse($classe);
                $classPromo->setPromo($unePromo);
                $classPromo->setLabel();
                $em->persist($classPromo);
            }
            $em->flush();
            $session = new Session();
            $session->getFlashBag()->add('classeOk', ''); // le message à l'utilisateur
            return $this->redirectToRoute('classe_show', ['classes' => $listClasse]); // pas le choix d'utiliser ce redirectToRoute pour evité le chargment d'un cache de merde !!!!
        } else {// sinon on affiche le formulaire
            return new Response($data);
        }
    }

    /**
     * @Route("/classe.html/remove/{id}", name="classe_remove")
     */
    public function removeAction($id)
    {
        /* config service */

        $em = $this->getDoctrine()->getManager();
        $classe = $em->getRepository('BackBundle:Classe')->find($id);
        $listClasse = $em->getRepository('BackBundle:Classe')->findAll();

        /* appel service */

        $this->container->get('back.method.actions')->removeAction($classe);
        $session = new Session();
        $session->getFlashBag()->add('classeDelete', '');


        return $this->redirectToRoute('classe_show', ['classe' => $listClasse]);
    }
}
