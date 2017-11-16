<?php

namespace BackBundle\Form;

use Doctrine\DBAL\Types\TextType;
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
            ->add('cA', MoneyType::class)
            ->add('adresse')
            ->add('zipCode', \Symfony\Component\Form\Extension\Core\Type\TextType::class, [
                'label'    => 'Code Postal',
                'required' => false,
            ])
            ->add('city', TextType::class, [
                'label'    => 'Ville',
                'required' => false,
            ])
            ->add('country', TextType::class, [
                'label'    => 'form.user.city',
                'required' => false,
            ])
            ->add('telephone', NumberType::class)
            ->add('valider', SubmitType::class);
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
