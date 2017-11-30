<?php

namespace BackBundle\Form;

use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EleveType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstName',null,array('required' => true))
            ->add('lastName',null,array('required' => true))
            ->add('phone',NumberType::class,array('required' => true))
            ->add('city',null,array('required' => true))
            ->add('zipCode',NumberType::class,array('required' => true))
            ->add('address',null,array('required' => true))
            ->add('email', TextType::class,array('required' => true))
            ->add('obtentionBac',null,array('required' => true))
            ->add('classePromo', EntityType::class, [
                'class' => 'BackBundle:ClassePromo',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->where('u.activeStatus = TRUE');
                }])
            ->add('diplome', EntityType::class, [
                'class' => 'BackBundle:Diplome',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->where('u.activeStatus = TRUE');
                }])
            ->add('Valider', SubmitType::class);
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'ConnexionBundle\Entity\User'
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
