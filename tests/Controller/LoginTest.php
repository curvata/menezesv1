<?php

namespace App\Tests\Controller;

use App\DataFixtures\TestFixtures;
use App\Repository\UserRepository;
use Liip\TestFixturesBundle\Services\DatabaseToolCollection;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class LoginTest extends WebTestCase
{

    public function loadFixtures()
    {
        self::getContainer()->get(DatabaseToolCollection::class)->get()->loadFixtures([TestFixtures::class]);
    }
    public function testLoginUserOffline()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/login');
        $this->assertResponseIsSuccessful();
        $this->assertEquals(
            1,
            $crawler->filter('label:contains("Mot de passe")')->count()
        );
        $this->assertSelectorTextContains('button', "Se connecter");
    }

    public function testLoginUserOnline()
    {
        $client = static::createClient();
        $this->loadFixtures();
        $userRepository = static::getContainer()->get(UserRepository::class);
        $testUser = $userRepository->findOneByEmail('mail@mail.be');
        $client->loginUser($testUser);
        $crawler = $client->request('GET', '/login');
        $response = $client->getResponse();
        $this->assertEquals('/admin', $response->headers->get('location'));
    }

    public function testLoginUser()
    {
        $client = static::createClient();
        $this->loadFixtures();
        $crawler = $client->request('GET', '/login');
        $form = $crawler->selectButton('Se connecter')->form();

        $crawler = $client->submit($form, [
            'email' => 'mail@mail.be',
            'password' => '%Password00',
        ]);
        $crawler = $client->followRedirect();
        $this->assertEquals(
            1,
            $crawler->filter('a:contains("Index des projets")')->count()
        );
    }
}
