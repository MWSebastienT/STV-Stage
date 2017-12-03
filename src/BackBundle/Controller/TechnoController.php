<?php

namespace BackBundle\Controller;

use BackBundle\Entity\Techno;
use BackBundle\Form\TechnoType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;

class TechnoController extends Controller
{
    /**
     * @Route("/techno", name="techno_index")
     */
    public function indexAction(Request $request)
    {
        $techno = new Techno();
        $em = $this->getDoctrine()->getManager();
        $listeTechno = $em->getRepository('BackBundle:Techno')->findAll();
        $em = $this->getDoctrine()->getManager();

        return $this->render('BackBundle:Techno:index.html.twig', [
            'Technos' => $listeTechno,
        ]);
    }

    /**
     * @Route("/techno/add", name="techno_add")
     */
    public function addAction(Request $request)
    {

        /* Config nécessaire au fonctionnement du service */

        $em = $this->getDoctrine()->getManager();
        $techno = new Techno();
        $form = $this->createForm(TechnoType::class, $techno);
        $entityName = 'Techno';
        $listTechno = $em->getRepository('BackBundle:Techno')->findAll();
        $action = 'edit';


        /* l'appel du service */

        $data = $this->container->get('back.method.actions')->formAction($request, $form, $techno, $entityName,$listTechno,
            $action,'Label');// true parce que j'utilise la table User pour add

        if ($data[0] == 'validate') // si on est dans la validation du formulaire
        {
            $session = new Session();
            $session->getFlashBag()->add('technok', ''); // le message à l'utilisateur

            return $this->redirectToRoute('techno_index', ['Technos' => $listTechno]); // pas le choix d'utiliser ce redirectToRoute pour evité le chargment d'un cache de merde !!!!
        } else {// sinon on affiche le formulaire
            return new \Symfony\Component\HttpFoundation\Response($data);
        }

    }

    /**
     * @Route("/techno/edit/{id}", name="techno_edit")
     */
    public function editAction(Request $request, $id)
    {
        /* Config nécessaire au fonctionnement du service */

        $em = $this->getDoctrine()->getManager();
        $techno = $em->getRepository('BackBundle:Techno')->find($id);
        $form = $this->createForm(TechnoType::class, $techno);
        $entityName = 'Techno';
        $listTechno = $em->getRepository('BackBundle:Techno')->findAll();

        /* l'appel du service */


        $session = new Session();
        $session->getFlashBag()->add('technoModif', '');// le message à l'utilisateur

        $data = $this->container->get('back.method.actions')->formAction($request, $form, $techno, $entityName,$listTechno,null,'Label');
        if ($data[0] == 'validate') // si on est dans la validation du formulaire
        {

            return $this->redirectToRoute('techno_index', ['Technos' => $listTechno]); // pas le choix d'utiliser ce redirectToRoute pour evité le chargment d'un cache de merde !!!!
        } else {// sinon on affiche le formulaire
            return new \Symfony\Component\HttpFoundation\Response($data);
        }
    }

    /**
     * @Route("/techno/remove/{id}", name="techno_remove")
     */
    public function removeAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $techno = $em->getRepository('BackBundle:Techno')->find($id);
        $this->container->get('back.method.actions')->removeAction($techno);
        $listTechno = $em->getRepository('BackBundle:Techno')->findAll();
        $session = new Session();
        $session->getFlashBag()->add('technoDeleteOk', ''); // le message à l'utilisateur

        return $this->redirectToRoute('techno_index', ['Technos' => $listTechno]);
    }
}
