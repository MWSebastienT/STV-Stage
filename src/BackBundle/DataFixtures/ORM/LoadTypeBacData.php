<?php

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use ConnexionBundle\Entity\User;



class LoadTypeBacData implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $entity = new \BackBundle\Entity\Diplome();
        $entity->setLabel('Scientifique');
        $manager->persist($entity);

        $entity = new \BackBundle\Entity\Diplome();
        $entity->setLabel('General');
        $manager->persist($entity);

        $entity = new \BackBundle\Entity\Diplome();
        $entity->setLabel('STG');
        $manager->persist($entity);
        $manager->flush();
    }
}

