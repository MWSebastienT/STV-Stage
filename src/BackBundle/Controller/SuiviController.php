<?php

namespace BackBundle\Controller;

use BackBundle\Form\EleveType;
use ConnexionBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;

class SuiviController extends Controller
{
    /**
     * @Route("/eleve.html", name="eleve_show")
     *
     */
    public function indexAction(Request $request, $listEleve = null)
    {
        if ($listEleve == null) {
            $em = $this->getDoctrine()->getManager();
            $listEleve = $em->getRepository('ConnexionBundle:User')->findByRole('ROLE_ELEVE');
        }
        return $this->render('BackBundle:Suivi:index.html.twig', array(
            'eleves' => $listEleve
        ));
    }

    /**
     * @Route("/eleve.html/edit/{id}", name="eleve_edit")
     */
    public function editAction(Request $request, $id)
    {
        /* Config nécessaire au fonctionnement du service */

        $em = $this->getDoctrine()->getManager();
        $eleve = $em->getRepository('ConnexionBundle:User')->find($id);
        $form = $this->createForm(EleveType::class, $eleve);
        $entityName = 'Suivi';
        $listEleve = $em->getRepository('ConnexionBundle:User')->findByRole('ROLE_ELEVE');

        /* l'appel du service */

        $data = $this->container->get('back.method.actions')->formAction($request, $form, $eleve, $entityName);
        if ($data[0] == 'validate') // si on est dans la validation du formulaire
        {
            $session = new Session();
            $session->getFlashBag()->add('eleveModif', '');// le message à l'utilisateur
            return $this->redirectToRoute('eleve_show', ['eleves' => $listEleve]); // pas le choix d'utiliser ce redirectToRoute pour evité le chargment d'un cache de merde !!!!
        } else {// sinon on affiche le formulaire
            return new Response($data);
        }
    }

    /**
     * @Route("/eleve.html/add", name="eleve_add")
     */
    public function addAction(Request $request)
    {

        /* Config nécessaire au fonctionnement du service */

        $em = $this->getDoctrine()->getManager();
        $eleve = new User;
        $form = $this->createForm(EleveType::class, $eleve);
        $entityName = 'Suivi';
        $listEleve = $em->getRepository('ConnexionBundle:User')->findByRole('ROLE_ELEVE');
        $action = 'edit';

        /* l'appel du service */

        $data = $this->container->get('back.method.actions')->formAction($request, $form, $eleve, $entityName,'ROLE_ELEVE',$action);// true parce que j'utilise la table User pour add
        if ($data[0] == 'validate') // si on est dans la validation du formulaire
        {
            $session = new Session();
            $session->getFlashBag()->add('eleveOk', ''); // le message à l'utilisateur
            return $this->redirectToRoute('eleve_show', ['eleves' => $listEleve]); // pas le choix d'utiliser ce redirectToRoute pour evité le chargment d'un cache de merde !!!!
        } else {// sinon on affiche le formulaire
            return new Response($data);
        }
    }

    /**
     * @Route("/eleve.html/remove/{id}", name="eleve_remove")
     */
    public function removeAction($id)
    {
        /* config service */

        $em = $this->getDoctrine()->getManager();
        $eleve = $em->getRepository('ConnexionBundle:User')->find($id);

        /* appel service */

        $this->container->get('back.method.actions')->removeAction($eleve);
        $listEleve = $em->getRepository('ConnexionBundle:User')->findByRole('ROLE_ELEVE');


        return $this->redirectToRoute('eleve_show',['eleve' => $listEleve]);
    }

}
