<?php

namespace App\Tests\Controller;

use App\DataFixtures\TestFixtures;
use App\Repository\UserRepository;
use Liip\TestFixturesBundle\Services\DatabaseToolCollection;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class AdminPictureTest extends WebTestCase
{

    public function loadFixtures()
    {
        self::getContainer()->get(DatabaseToolCollection::class)->get()->loadFixtures([TestFixtures::class]);
    }
    public function testAdminDeparture()
    {
        $client = static::createClient();
        $this->loadFixtures();
        $userRepository = static::getContainer()->get(UserRepository::class);
        $testUser = $userRepository->findOneByEmail('mail@mail.be');
        $client->loginUser($testUser);
        $client->request('GET', '/admin/pictures/project/1');
        $data = json_decode($client->getResponse()->getContent(), true);
        $this->assertStringContainsString('1', $data[0][0]);
        $this->assertStringContainsString('small_picture.jpeg', $data[0][1]);
    }
}
