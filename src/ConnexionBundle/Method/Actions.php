<?php

namespace ConnexionBundle\Method;

use Symfony\Component\Form\FormFactory;
use BackBundle\Form\EleveType;
use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;

class Actions

{
    private $em;
    private $form;

    public function __construct(EntityManager $em, FormFactory $formFactory)
    {
        $this->em = $em;
        $this->form = $formFactory;
    }

    public function editAction(Request $request, $id)
    {
        $em = $this->em;
        $listEleve = $em->getRepository('ConnexionBundle:User')->findByRole('ROLE_ELEVE');
        $eleve = $em->getRepository('ConnexionBundle:User')->find($id); // on déclare un nouvelle élève qui est dans la class User de connexionBundle
        $form = $this->form->create(EleveType::class, $eleve);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($eleve);
            $em->flush();
            $session = new Session();
            $session->getFlashBag()->add('eleveOk', 'Elève modifié avec succès !');
            return array('action' => 'edit', 'id' => $eleve->getId(), 'eleves' => $listEleve, 'form' => $form);
        }
        return array(
            'data' => [
                'form' => $form->createView(),
                'eleves' => $listEleve
            ]
        );
    }
}