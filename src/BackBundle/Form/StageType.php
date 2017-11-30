<?php

namespace BackBundle\Form;

use ConnexionBundle\ConnexionBundle;
use ConnexionBundle\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;

class StageType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
            ->add('dateDebut')
            ->add('dateFin')
            ->add('lesTechno', EntityType::class, [
                'class'    => 'BackBundle:Techno',
                'multiple' => true,
            ])
            ->add('leEleve')
            ->add('leReferentPro', EntityType::class, [
                'class' => 'ConnexionBundle',
                'choices' => $group->getUsers(),
            ])
            ->add('leReferentPeda')
            ->add('leEntreprise')
            ->add('Valider', SubmitType::class);
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'BackBundle\Entity\Stage',
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'backbundle_stage';
    }


}
