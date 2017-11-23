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
    public function indexAction(Request $request,$listEleve = null)
    {
        if($listEleve == null)
        {
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
    public function editAction(Request $request,$id)
    {
        /* Config du service */

        $em = $this->getDoctrine()->getManager();
        $eleve = $em->getRepository('ConnexionBundle:User')->find($id);
        $form = $this->createForm(EleveType::class, $eleve);
        $entityName = 'Suivi';
        $listEleve = $em->getRepository('ConnexionBundle:User')->findByRole('ROLE_ELEVE');
        $paramFormValide = ['eleves' => $listEleve];
        $redirect = $this->redirectToRoute('eleve_show');

        /* l'appel du service */

        $data = $this->container->get('back.method.actions')->formAction($request,$form,$eleve,$entityName,$paramFormValide,$redirect);
        return new Response($data) ;
    }

    /**
     * @Route("/eleve.html/add", name="eleve_add")
     */
    public function addAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $eleve = new User;
        $form = $this->createForm(EleveType::class, $eleve);
        $entityName = 'Suivi';
        $listEleve = $em->getRepository('ConnexionBundle:User')->findByRole('ROLE_ELEVE');
        $paramFormValide = ['eleves' => $listEleve];
        $redirect = $this->redirectToRoute('eleve_show');

        $data = $this->container->get('back.method.actions')->formAction($request,$form,$eleve,$entityName,$paramFormValide,true,$redirect);
        return new Response($data) ;
    }

}
