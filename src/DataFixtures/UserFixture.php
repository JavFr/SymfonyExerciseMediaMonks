<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class UserFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $user = new User();
        $user->setFullname('Javier Brustolon');
        $user->setEmail('jav.brustolon@gmail.com');
        $user->setCreatedAt(new \DateTimeImmutable());
        $user->setRoles(['ROLE_ADMIN']);

        $manager->persist($user);

        $manager->flush();
    }
}
