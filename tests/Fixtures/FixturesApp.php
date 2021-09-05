<?php

namespace App\Tests;

use App\DataFixtures\AppFixtures;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class FixturesApp extends WebTestCase
{

    public function loadFixtures()
    {
        self::getContainer()->get(DatabaseToolCollection::class)->get()->loadFixtures([AppFixtures::class]);
    }

    public function testFixturesTest()
    {
        $this->loadFixtures();
        $users = static::getContainer()->get(UserRepository::class)->findAll();

        $this->assertCount(1, $users);
        $this->assertStringContainsString("mail@mail.be", $users[0]->getEmail());
    }
}
