<?php

namespace App\Repository;

use App\DataFixtures\TestFixtures;
use Liip\TestFixturesBundle\Services\DatabaseToolCollection;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class UserRepositoryTest extends WebTestCase
{
    public function loadFixtures()
    {
        self::getContainer()->get(DatabaseToolCollection::class)->get()->loadFixtures([TestFixtures::class]);
    }

    public function testFindAll()
    {
        $this->loadFixtures();
        $users = static::getContainer()->get(UserRepository::class)->findAll();

        $this->assertCount(1, $users);
        $this->assertStringContainsString("mail@mail.be", $users[0]->getEmail());
    }
}
