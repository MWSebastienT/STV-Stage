<?php

namespace BackBundle\Controller;

use BackBundle\Entity\Entreprise;
use BackBundle\Entity\typeEntreprise;
use ConnexionBundle\Entity\User;
use BackBundle\Form\EntrepriseType;
use ConnexionBundle\Form\RefProType;
use ConnexionBundle\Form\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;

class EntrepriseController extends Controller
{
    /**
     * @Route("/entreprise", name="entreprise_index")
     */
    public function indexAction(Request $request)
    {
        $entreprise = new Entreprise();
        $em = $this->getDoctrine()->getManager();
        $listeEntreprise = $em->getRepository('BackBundle:Entreprise')->findAll();
        $em = $this->getDoctrine()->getManager();
        return $this->render('BackBundle:Entreprise:index.html.twig', [
            'entreprises' => $listeEntreprise,
        ]);
    }

    /**
     * @Route("/entreprise/show/{id}", name="entreprise_show")
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $stage = new Entreprise();
        $entreprise = $em->getRepository('BackBundle:Entreprise')->find($id);
        $form = $this->createForm(EntrepriseType::class, $stage);
        $listeEntreprise = $em->getRepository('BackBundle:Entreprise')->findAll();
        $lesRefPro = $entreprise->getLesReferentPro();
        $lesStages = $entreprise->getLesStages();


        return $this->render('BackBundle:Entreprise:ficheEntreprise.html.twig', [
            'entreprises' => $listeEntreprise,
            'entreprise' => $entreprise,
            'lesRefPro' => $lesRefPro,
            'lesStages' => $lesStages
        ]);
    }
    /**
     * @Route("/entreprise/edit/{id}", name="entreprise_edit")
     */
    public function editAction(Request $request, $id)
    {
        /* Config nécessaire au fonctionnement du service */

        $em = $this->getDoctrine()->getManager();
        $stage = $em->getRepository('BackBundle:Entreprise')->find($id);
        $form = $this->createForm(EntrepriseType::class, $stage);
        $entityName = 'Entreprise';
        $listEntreprise = $em->getRepository('BackBundle:Entreprise')->findAll();

        /* l'appel du service */

        $data = $this->container->get('back.method.actions')->formAction($request, $form, $stage, $entityName,$listEntreprise,null,'Nom');
        if ($data[0] == 'validate') // si on est dans la validation du formulaire
        {
            $session = new Session();
            $session->getFlashBag()->add('entrepriseModif', '');// le message à l'utilisateur

            return $this->redirectToRoute('entreprise_index', ['entreprise' => $listEntreprise]); // pas le choix d'utiliser ce redirectToRoute pour evité le chargment d'un cache de merde !!!!
        } else {// sinon on affiche le formulaire
            return new Response($data);
        }
    }

    /**
     * @Route("/entreprise/add", name="entreprise_add")
     */
    public function addAction(Request $request)
    {

        /* Config nécessaire au fonctionnement du service */

        $em = $this->getDoctrine()->getManager();
        $entreprise = new Entreprise();
        $form = $this->createForm(EntrepriseType::class, $entreprise);
        $entityName = 'Entreprise';
        $listEntreprise = $em->getRepository('BackBundle:Entreprise')->findAll();
        $action = 'edit';

        /* l'appel du service */

        $data = $this->container->get('back.method.actions')->formAction($request, $form, $entreprise, $entityName,$listEntreprise,
            $action,'Nom');

        if ($data[0] == 'validate') // si on est dans la validation du formulaire
        {
            $session = new Session();
            $session->getFlashBag()->add('entrepriseOk', ''); // le message à l'utilisateur
            return $this->redirectToRoute('entreprise_index', ['entreprises' => $listEntreprise]); // pas le choix d'utiliser ce redirectToRoute pour evité le chargement d'une page blanche avant la redirectionn ... !!!!
        } else {// sinon on affiche le formulaire
            return new Response($data);
        }
    }

    /**
     * @Route("/entreprise/remove/{id}", name="entreprise_remove")
     */
    public function removeAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $entreprise = $em->getRepository('BackBundle:Entreprise')->find($id);
        $this->container->get('back.method.actions')->removeAction($entreprise);
        $listEntreprise = $em->getRepository('BackBundle:Entreprise')->findAll();
        $session = new Session();
        $session->getFlashBag()->add('enterpriseDeleteOk', ''); // le message à l'utilisateur
        return $this->redirectToRoute('entreprise_index',['entreprise' => $listEntreprise]);
    }

}
