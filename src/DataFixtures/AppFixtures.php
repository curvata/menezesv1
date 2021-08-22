<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $user = new User();
        $user
        ->setEmail('mail@mail.be')
        ->setRoles(['ROLE_ADMIN'])
        ->setPassword('$argon2id$v=19$m=65536,t=4,p=1$flIblTtYgRo8pmzFVZNxCg$ERQmU8E9+lR9qFeMXVrBCP7EU/1F+ggQ7mdOUO43lHA'); // %Password00

        $manager->persist($user);
        $manager->flush();
    }
}
