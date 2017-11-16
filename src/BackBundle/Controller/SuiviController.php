<?php

namespace BackBundle\Controller;

use BackBundle\Form\EleveType;
use ConnexionBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;

class SuiviController extends Controller
{
    /**
     * @Route("/suivi.html", name="suivi_show")
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $listEleve = $em->getRepository('ConnexionBundle:User')->findByRole('ROLE_ELEVE');
        $eleve = new User(); // on déclare un nouvelle élève qui est dans la class User de connexionBundle
        $form = $this->get('form.factory')->create(EleveType::class, $eleve);
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

            return $this->redirectToRoute('suivi_show', array('id' => $eleve->getId(), 'eleves' => $listEleve));
        }
        return $this->render('BackBundle:Suivi:index.html.twig', array(
            'form' => $form->createView(),
            'eleves' => $listEleve
        ));
    }
}
