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
     * @Route("/entreprise/show/{id}/RefPeda/add", name="entreprise_add_refpeda")
     */
    public function addRefProAction($id, Request $request)
    {

        /* Config nécessaire au fonctionnement du service */

        $em = $this->getDoctrine()->getManager();
        $refPeda = new User();
        $form = $this->createForm(RefPedaType::class, $refPeda);
        $entityName = 'RefPeda';
        $listEntreprise = $em->getRepository('BackBundle:Entreprise')->findAll();
        $entreprise = $em->getRepository('BackBundle:Entreprise')->find($id);
        $action = 'edit';


        /* l'appel du service */

        $data = $this->container->get('back.method.actions')->formAction($request, $form, $refPeda, $entityName,
            $action,'ROLE_REF_PEDA');// true parce que j'utilise la table User pour add
        if ($data[0] == 'validate') // si on est dans la validation du formulaire
        {
            $refPeda->setLeEntreprise($entreprise);
            $em->persist($refPeda);
            $em->flush();
            $session = new Session();
            $session->getFlashBag()->add('refPedaOk', ''); // le message à l'utilisateur
            return $this->redirectToRoute('entreprise_show', ['entreprises' => $listEntreprise, 'entreprise' => $entreprise, 'id' => $id]); // pas le choix d'utiliser ce redirectToRoute pour evité le chargment d'un cache de merde !!!!
        } else {// sinon on affiche le formulaire
            return new Response($data);
        }
    }
}
