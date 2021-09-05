<?php

namespace App\Tests\Controller;

use App\DataFixtures\TestFixtures;
use Liip\TestFixturesBundle\Services\DatabaseToolCollection;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class HomeTest extends WebTestCase
{
    public function loadFixtures()
    {
        self::bootKernel();
        self::getContainer()->get(DatabaseToolCollection::class)->get()->loadFixtures([TestFixtures::class]);
    }
    public function testHome()
    {
        $client = static::createClient();
        $this->loadFixtures();

        $crawler = $client->request('GET', '/');
        $this->assertResponseIsSuccessful();

        $this->assertSelectorTextContains('h1', "Salut ! Moi c'est Mike Je suis développeur web");
        $this->assertSelectorTextContains('.title', "Mes réalisations");
        $this->assertSelectorTextContains('.subtitle', "Découvrez quelques une des mes créations");
        $this->assertSelectorTextContains('h3', "un projet");
        $this->assertEquals(
            1,
            $crawler->filter('.menu_link:contains("Réalisations")')->count()
        );
    }
}
