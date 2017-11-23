<?php

namespace BackBundle\Method;

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

    public function formAction(Request $request,$form,$object,$entityName,$eleve = false,$redirect)
    {
        $em = $this->em;
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if($eleve == false)
            {
                  //on fait rien de spécialle pour l'instant
            }
            else{// si c'est un élève
                $firstName = $object->getFirstName();
                $lastName = $object->getLastName();
                $object->setEmailCanonical($request->get('email')); // je sais pas à quoi sert ce champs mais il ne doit pas être nul donc on met dedans le même mail saisi pour le champs email
                $object->setUsername($lastName.' '.$firstName);
                $object->setEnabled(1);// on active l'élève
                $object->setPlainPassword('on s en fou du mot de passe mais faut pas que ça soit null');
                $object->setRoles(['ROLE_ELEVE']); // on ajoute le role
                $object->setUsernameCanonical($request->get('id')); // pareil je sais aps à quoi sert ce c
            }
            $em->persist($object);
            $em->flush();
            return $redirect;
        }
        return
            $this->templating->render('BackBundle:'.$entityName.':form_base.html.twig',['form' => $form->createView()]);
    }
}