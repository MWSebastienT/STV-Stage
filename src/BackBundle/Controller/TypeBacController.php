<?php

namespace BackBundle\Controller;

use BackBundle\Entity\Diplome;
use BackBundle\Form\DiplomeType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;

class TypeBacController extends Controller
{
    /**
     * @Route("/bac", name="type_bac_show")
     *
     */
    public function indexAction(Request $request, $listBac = null)
    {
        if ($listBac == null) {
            $em = $this->getDoctrine()->getManager();
            $listBac = $em->getRepository('BackBundle:Diplome')->findAll();
        }
        return $this->render('BackBundle:TypeBac:index.html.twig', array(
            'lesBacs' => $listBac
        ));
    }


    /**
     * @Route("/bac/edit/{id}", name="type_bac_edit")
     */
    public function editAction(Request $request, $id)
    {
        /* Config nécessaire au fonctionnement du service */

        $em = $this->getDoctrine()->getManager();

        /* @var Diplome $bac */
        $bac = $em->getRepository('BackBundle:Diplome')->find($id);

        $form = $this->createForm(DiplomeType::class, $bac);
        $entityName = 'TypeBac';
        $listBac = $em->getRepository('BackBundle:Diplome')->findAll();

        /* l'appel du service */

        $data = $this->container->get('back.method.actions')->formAction($request, $form, $bac, $entityName);
        if ($data[0] == 'validate') // si on est dans la validation du formulaire
        {
            $session = new Session();
            $session->getFlashBag()->add('bacModif', '');// le message à l'utilisateur
            return $this->redirectToRoute('type_bac_show', ['lesBacs' => $listBac]); // pas le choix d'utiliser ce redirectToRoute pour evité le chargment d'un cache de merde !!!!
        } else {// sinon on affiche le formulaire
            return new Response($data);
        }
    }

    /**
     * @Route("/bac/add", name="type_bac_add")
     */
    public function addAction(Request $request)
    {

        /* Config nécessaire au fonctionnement du service */

        $em = $this->getDoctrine()->getManager();
        $bac = new Diplome();
        $form = $this->createForm(DiplomeType::class, $bac);
        $entityName = 'TypeBac';
        $listBac = $em->getRepository('BackBundle:Diplome')->findAll();
        $action = 'edit';

        /* l'appel du service */

        $data = $this->container->get('back.method.actions')->formAction($request, $form, $bac, $entityName, $action,null,'yo');// true parce que j'utilise la table User pour add
        if ($data[0] == 'validate') // si on est dans la validation du formulaire
        {
            $session = new Session();
            $session->getFlashBag()->add('bacOk', ''); // le message à l'utilisateur
            return $this->redirectToRoute('type_bac_show', ['lesBacs' => $listBac]); // pas le choix d'utiliser ce redirectToRoute pour evité le chargment d'un cache de merde !!!!
        } else {// sinon on affiche le formulaire
            return new Response($data);
        }
    }

    /**
     * @Route("/bac/remove/{id}", name="type_bac_remove")
     */
    public function removeAction($id)
    {
        /* config service */

        $em = $this->getDoctrine()->getManager();
        $bac = $em->getRepository('BackBundle:Diplome')->find($id);
        $listBac = $em->getRepository('BackBundle:Diplome')->findAll();

        /* appel service */

        $this->container->get('back.method.actions')->removeAction($bac);
        $session = new Session();
        $session->getFlashBag()->add('eleveDelete', '');
        return $this->redirectToRoute('type_bac_show', ['lesBacs' => $listBac]);
    }
}
