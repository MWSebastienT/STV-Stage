<?php

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use ConnexionBundle\Entity\User;



class LoadTechnoData implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $entity = new \BackBundle\Entity\Techno();
        $entity->setLabel('PHP');
        $manager->persist($entity);

        $entity = new \BackBundle\Entity\Techno();
        $entity->setLabel('C#');
        $manager->persist($entity);

        $entity = new \BackBundle\Entity\Techno();
        $entity->setLabel('Angular');
        $manager->persist($entity);
        $manager->flush();
    }
}
?>
