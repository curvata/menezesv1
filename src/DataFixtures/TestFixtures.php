<?php

namespace App\DataFixtures;

use App\Entity\Picture;
use App\Entity\Project;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class TestFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $user = (new User())
            ->setEmail('mail@mail.be')
            ->setRoles(['ROLE_ADMIN'])
            ->setPassword('$argon2id$v=19$m=65536,t=4,p=1$flIblTtYgRo8pmzFVZNxCg$ERQmU8E9+lR9qFeMXVrBCP7EU/1F+ggQ7mdOUO43lHA'); // %Password00

        $manager->persist($user);

        $picture = (new Picture())->setFilename('picture.jpeg');

        $manager->persist($picture);

        $project = (new Project())
            ->setTitle("un projet")
            ->setDescription("une super description de pour un projet de test")
            ->setLinkGithub("curvata/test")
            ->setLinkWeb("test.menezes.be");

        $project->addPicture($picture);

        $manager->persist($project);
        $manager->flush();
    }
}
