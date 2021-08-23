<?php

namespace App\DataFixtures;

use App\Entity\Home;
use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Exception;
use ZipArchive;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $user = (new User())
            ->setEmail('mail@mail.be')
            ->setRoles(['ROLE_ADMIN'])
            ->setPassword('$argon2id$v=19$m=65536,t=4,p=1$flIblTtYgRo8pmzFVZNxCg$ERQmU8E9+lR9qFeMXVrBCP7EU/1F+ggQ7mdOUO43lHA'); // %Password00

        $home = (new Home())
            ->setIntro("Un super texte d'introduction")
            ->setAboutMe("Salut moi c'est Mike ! Voici une magnifique description de moi")
            ->setPicture("menezes.jpg");

        $manager->persist($user);
        $manager->persist($home);
        $manager->flush();

        $zip = new ZipArchive;

        if ($zip->open(dirname(__DIR__).'/DataFixtures/pictures.zip') === true) {
            $zip->extractTo(dirname(__DIR__, 2).'/public/images/');
            $zip->close();
            echo 'pictures ok';
        } else {
            throw new Exception("Impossible d'extraire l'archive pictures.zip dans le images");
        }
    }
}
