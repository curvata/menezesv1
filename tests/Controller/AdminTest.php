<?php

namespace App\Tests\Controller;

use App\DataFixtures\TestFixtures;
use App\Repository\UserRepository;
use Liip\TestFixturesBundle\Services\DatabaseToolCollection;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class AdminTest extends WebTestCase
{
    public function loadFixtures()
    {
        self::getContainer()->get(DatabaseToolCollection::class)->get()->loadFixtures([TestFixtures::class]);
    }

    public function testOffline()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/admin/project/');
        $this->assertResponseRedirects();
        $crawler = $client->followRedirect();
        $this->assertEquals(
            1,
            $crawler->filter('button:contains("Se connecter")')->count()
        );
    }

    public function testAdminDashboard()
    {
        $client = static::createClient();
        $this->loadFixtures();
        $userRepository = static::getContainer()->get(UserRepository::class);
        $testUser = $userRepository->findOneByEmail('mail@mail.be');
        $client->loginUser($testUser);
        $crawler = $client->request('GET', '/admin');
        $this->assertResponseIsSuccessful();
        $this->assertEquals(
            1,
            $crawler->filter('a:contains("Index des projets")')->count()
        );
    }
    public function testIndexProjectAdmin()
    {
        $client = static::createClient();
        $this->loadFixtures();
        $userRepository = static::getContainer()->get(UserRepository::class);
        $testUser = $userRepository->findOneByEmail('mail@mail.be');
        $client->loginUser($testUser);
        $crawler = $client->request('GET', '/admin/project/');
        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', "Index des projets");
        $this->assertEquals(
            1,
            $crawler->filter('td:contains("un projet")')->count()
        );
    }
}
