<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;


class UserFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $user = new User();
        $user->setEmail('renatoaugusto.ads@gmail.com');
        $user->setPassword('$2y$13$jjIZTLdRL6FTNxdPWt1tA.H7LpjsD0SDWDW4Tt3fUW7wVu9Fa4/lm');
        $user->setRoles(['ROLE_USER', 'ROLE_ADMIN']);
        $manager->persist($user);
        $manager->flush();
    }
}
