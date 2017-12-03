<?php

namespace BackBundle\Controller;

use BackBundle\Entity\Entreprise;
use BackBundle\Entity\typeEntreprise;
use ConnexionBundle\Entity\User;
use ConnexionBundle\Form\RefProType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;

class RefProController extends Controller
{
    /**
     * @Route("/refPro", name="refPro_index")
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $listeRefPro= $em->getRepository('ConnexionBundle:User')->findByRole('ROLE_REF_PRO');
        $em = $this->getDoctrine()->getManager();
        return $this->render('BackBundle:RefPro:index.html.twig', [
            'refPros' => $listeRefPro
        ]);
    }

    /**
     * @Route("/refPro/add", name="refPro_add")
     */
    public function addRefProAction(Request $request)
    {

        /* Config nécessaire au fonctionnement du service */

        $em = $this->getDoctrine()->getManager();
        $refPro = new User();
        $form = $this->createForm(RefProType::class, $refPro);
        $entityName = 'RefPro';
        $listRefPro = $em->getRepository('ConnexionBundle:User')->findByRole('ROLE_REF_PRO');
        $action = 'edit';


        /* l'appel du service */
        $data = $this->container->get('back.method.actions')->formAction($request, $form, $refPro, $entityName,$listRefPro,$action,null,'ROLE_REF_PRO');// true parce que j'utilise la table User pour add
        if ($data[0] == 'validate') // si on est dans la validation du formulaire
        {
            $session = new Session();
            $session->getFlashBag()->add('refProOk', ''); // le message à l'utilisateur
            return $this->redirectToRoute('refPro_index', ['refPros' => $listRefPro]); // pas le choix d'utiliser ce redirectToRoute pour evité le chargment d'un cache de merde !!!!
        } else {// sinon on affiche le formulaire
            return new Response($data);
        }
    }

    /**
     * @Route("/RefPro/edit/{id}", name="refPro_edit")
     */
    public function editAction(Request $request, $id)
    {
        /* Config nécessaire au fonctionnement du service */

        $em = $this->getDoctrine()->getManager();
        $refPro = $em->getRepository('ConnexionBundle:User')->find($id);
        $form = $this->createForm(RefProType::class, $refPro);
        $entityName = 'RefPro';
        $listRefPro = $em->getRepository('ConnexionBundle:User')->findByRole('ROLE_REF_PRO');

        /* l'appel du service */

        $data = $this->container->get('back.method.actions')->formAction($request, $form, $refPro, $entityName,$listRefPro);
        if ($data[0] == 'validate') // si on est dans la validation du formulaire
        {
            $session = new Session();
            $session->getFlashBag()->add('refProModif', '');// le message à l'utilisateur

            return $this->redirectToRoute('refPro_index', ['RefPedas' => $listRefPro]); // pas le choix d'utiliser ce redirectToRoute pour evité le chargment d'un cache de merde !!!!
        } else {// sinon on affiche le formulaire
            return new \Symfony\Component\HttpFoundation\Response($data);
        }
    }

    /**
     * @Route("/RefPro/delete/{id}", name="refPro_remove")
     */
    public function removeAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $refPro = $em->getRepository('ConnexionBundle:User')->find($id);
        $this->container->get('back.method.actions')->removeAction($refPro);
        $listRefPro= $em->getRepository('ConnexionBundle:User')->findByRole('ROLE_REF_PRO');
        $session = new Session();
        $session->getFlashBag()->add('refProDeleteOk', ''); // le message à l'utilisateur
        return $this->redirectToRoute('refPro_index',['refPros' => $listRefPro]);
    }
}
