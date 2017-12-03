<?php

namespace BackBundle\Controller;

use BackBundle\Entity\Entreprise;
use BackBundle\Entity\typeEntreprise;
use ConnexionBundle\Entity\User;
use ConnexionBundle\Form\RefPedaType;
use ConnexionBundle\Form\RefProType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;

class RefPedaController extends Controller
{

    /**
     * @Route("/refpeda", name="refpeda_index")
     */
    public function indexAction(Request $request)
    {
        $typeEntreprise = new typeEntreprise();
        $em = $this->getDoctrine()->getManager();
        $listeRefPeda = $em->getRepository('ConnexionBundle:User')->findByRole('ROLE_REF_PEDA');
        $em = $this->getDoctrine()->getManager();
        return $this->render('BackBundle:RefPeda:index.html.twig', [
            'refPedas' => $listeRefPeda
        ]);
    }


    /**
     * @Route("/RefPeda/add", name="refpeda_add")
     */
    public function addRefProAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $refPeda = new User();
        $form = $this->createForm(RefPedaType::class, $refPeda);
        $entityName = 'RefPeda';
        $listRefPeda = $em->getRepository('ConnexionBundle:User')->findByRole('ROLE_REF_PEDA');
        $action = 'edit';

        /* l'appel du service */

        $data = $this->container->get('back.method.actions')->formAction($request, $form, $refPeda, $entityName,$listRefPeda,
            $action,null, 'ROLE_REF_PEDA');// true parce que j'utilise la table User pour add
        if ($data[0] == 'validate') // si on est dans la validation du formulaire
        {
            $session = new Session();
            $session->getFlashBag()->add('refPedaOk', ''); // le message à l'utilisateur
            return $this->redirectToRoute('refpeda_index', ['RefPedas' => $listRefPeda]);
        } else {// sinon on affiche le formulaire
            return new \Symfony\Component\HttpFoundation\Response($data);
        }
    }

    /**
     * @Route("/RefPeda/edit/{id}", name="refpeda_edit")
     */
    public function editAction(Request $request, $id)
    {
        /* Config nécessaire au fonctionnement du service */

        $em = $this->getDoctrine()->getManager();
        $refPeda = $em->getRepository('ConnexionBundle:User')->find($id);
        $form = $this->createForm(RefPedaType::class, $refPeda);
        $entityName = 'RefPeda';
        $listRefPeda = $em->getRepository('ConnexionBundle:User')->findByRole('ROLE_REF_PEDA');

        /* l'appel du service */

        $data = $this->container->get('back.method.actions')->formAction($request, $form, $refPeda, $entityName,$listRefPeda);
        if ($data[0] == 'validate') // si on est dans la validation du formulaire
        {
            $session = new Session();
            $session->getFlashBag()->add('refpedaModif', '');// le message à l'utilisateur

            return $this->redirectToRoute('refpeda_index', ['RefPedas' => $listRefPeda]); // pas le choix d'utiliser ce redirectToRoute pour evité le chargment d'un cache de merde !!!!
        } else {// sinon on affiche le formulaire
            return new \Symfony\Component\HttpFoundation\Response($data);
        }
    }

    /**
     * @Route("/RefPeda/delete/{id}", name="refpeda_remove")
     */
    public function removeAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $refPeda = $em->getRepository('ConnexionBundle:User')->find($id);
        $this->container->get('back.method.actions')->removeAction($refPeda);
        $listRefPeda= $em->getRepository('ConnexionBundle:User')->findByRole('ROLE_REF_PEDA');
        $session = new Session();
        $session->getFlashBag()->add('refpedaDeleteOk', ''); // le message à l'utilisateur
        return $this->redirectToRoute('refpeda_index',['refPedas' => $listRefPeda]);
    }
}
