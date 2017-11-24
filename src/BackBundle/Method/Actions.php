<?php

namespace BackBundle\Method;

use Psr\Container\ContainerInterface;
use Symfony\Component\Form\FormFactory;
use BackBundle\Form\EleveType;
use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Router;
use Symfony\Component\Routing\RouterInterface;

class Actions
{
    private $em;
    private $router;

    public function __construct(EntityManager $em, $templating)
    {
        $this->em = $em;
        $this->templating = $templating;
    }

    /* paramètres
     *  $form -> le formulaire avec le formtype
     *  $object -> l'objet sur lequelle on travaille exemple $eleve = $em->getRepository('blabalbal')->find($id) ou alors $eleve = new User();
     *  $entityName -> le nom de la classe sur laquelle on travaille ( majuscule sur la premièr elettre )
     *  $role -> Le role en string lors d'un add User (jamais true pour les edits)
     *  $action -> permet d'identifier dans quel action on se trouve pour le titre du formulaire ^^
    */
    public function formAction(Request $request,$form,$object,$entityName,$action=null,$role=null)
    {
        $em = $this->em;
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if($role != "")
            {
                $firstName = $object->getFirstName();
                $lastName = $object->getLastName();
                $object->setEmailCanonical($request->get('email')); // je sais pas à quoi sert ce champs mais il ne doit pas être nul donc on met dedans le même mail saisi pour le champs email
                $object->setUsername($lastName.' '.$firstName);
                $object->setEnabled(1);// on active l'élève
                $object->setPlainPassword('on s en fou du mot de passe mais faut pas que ça soit null');
                $object->setRoles([$role]); // on ajoute le role
                $object->setUsernameCanonical($request->get('id')); // pareil je sais pas à quoi sert ce c
            }
            $em->persist($object);
            $em->flush();
            return array(0 => 'validate');
        }
        return
            $this->templating->render('BackBundle:'.$entityName.':form_base.html.twig',['state'=>'show','form' => $form->createView(),'action'=>$action]);
    }

    public function removeAction($object)
    {
        $em = $this->em;
        $em->remove($object);
        $em->flush();
    }

}
