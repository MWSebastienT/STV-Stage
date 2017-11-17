<?php

namespace BackBundle\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EntrepriseType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom')
            ->add('leTypeEnt', EntityType::class, array(
                'class' => 'BackBundle:typeEntreprise',
                'choice_label' => 'label'
            ))
            ->add('cA', MoneyType::class)
            ->add('adresse')
            ->add('zipCode', TextType::class, [
                'label'    => 'Code Postal',
                'required' => false,
            ])
            ->add('city', TextType::class, [
                'label'    => 'Ville',
                'required' => false,
            ])
            ->add('country', TextType::class, [
                'label'    => 'Pays',
                'required' => false,
            ])
            ->add('telephone', NumberType::class)
            ->add('LesReferentPro', EntityType::class, [
                'class' => 'ConnexionBundle:User',
                'multiple' => true,
            ])
            ->add('Valider', SubmitType::class);
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'BackBundle\Entity\Entreprise'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'backbundle_entreprise';
    }


}
