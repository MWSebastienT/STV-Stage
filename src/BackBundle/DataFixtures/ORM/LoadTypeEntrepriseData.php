<?php

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use ConnexionBundle\Entity\User;



class LoadTypeEntrepriseData implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $entity = new \BackBundle\Entity\typeEntreprise();
        $entity->setLabel('Agence Web');
        $manager->persist($entity);

        $entity = new \BackBundle\Entity\typeEntreprise();
        $entity->setLabel('Agence Communication');
        $manager->persist($entity);

        $entity = new \BackBundle\Entity\typeEntreprise();
        $entity->setLabel('Agence SEO');
        $manager->persist($entity);
        $manager->flush();
    }
}
?>
