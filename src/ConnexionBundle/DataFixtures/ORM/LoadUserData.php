<?php

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use ConnexionBundle\Entity\User;



class LoadUserData implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $entity = new User();
        $entity->setUsername('admin');
        $entity->setPlainPassword('admin');
        $entity->setEmail('');
        $role = array('ROLE_ADMIN');
        $entity->setEnabled(1);
        $entity->setRoles($role);
        $entity->setActiveStatus(1);
        $manager->persist($entity);
        $manager->flush();
    }
}
?>
