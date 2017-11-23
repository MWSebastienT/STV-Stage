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
     */
    public function indexAction($listEleve = null)
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
        $em = $this->getDoctrine()->getManager();
        $listEleve = $em->getRepository('ConnexionBundle:User')->findByRole('ROLE_ELEVE');
        $eleve = $em->getRepository('ConnexionBundle:User')->find($id); // on déclare un nouvelle élève qui est dans la class User de connexionBundle
        $form = $this->createForm(EleveType::class, $eleve);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($eleve);
            $em->flush();
            $session = new Session();
            $session->getFlashBag()->add('eleveOk', 'Elève modifié avec succès !');
            return $this->indexAction($listEleve);
        }

        return $this->render('BackBundle:Suivi:form_base.html.twig', array(
            'form' => $form->createView(),
            'eleves' => $listEleve
        ));
    }

    /**
     * @Route("/eleve.html/add", name="eleve_add")
     */
    public function addAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $listEleve = $em->getRepository('ConnexionBundle:User')->findByRole('ROLE_ELEVE');// voir méthode ecrite dans UserRepository
        $eleve = new User(); // on déclare un nouvelle élève qui est dans la class User de connexionBundle
        $form = $this->createForm(EleveType::class, $eleve);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $firstName = $eleve->getFirstName();
            $lastName = $eleve->getLastName();
            $eleve->setEmailCanonical($request->get('email')); // je sais pas à quoi sert ce champs mais il ne doit pas être nul donc on met dedans le même mail saisi pour le champs email
            $eleve->setUsername($lastName.' '.$firstName);
            $eleve->setEnabled(1);// on active l'élève
            $eleve->setPlainPassword('on s en fou du mot de passe mais faut pas que ça soit null');
            $eleve->setRoles(['ROLE_ELEVE']); // on ajoute le role
            $eleve->setUsernameCanonical($request->get('id')); // pareil je sais aps à quoi sert ce champs mais il doit pas être nul donc on met les même username
            $em->persist($eleve);
            $em->flush();
            $session = new Session();
            $session->getFlashBag()->add('eleveOk', 'Elève ajouté avec succès !');
            return $this->indexAction($listEleve);
        }
        return $this->render('BackBundle:Suivi:form_base.html.twig', array(
            'form' => $form->createView(),
            'eleves' => $listEleve
        ));
    }
}
