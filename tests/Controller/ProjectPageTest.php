<?php

namespace App\Tests\Controller;

use App\DataFixtures\TestFixtures;
use Liip\TestFixturesBundle\Services\DatabaseToolCollection;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ProjectPageTest extends WebTestCase
{
    public function loadFixtures()
    {
        self::getContainer()->get(DatabaseToolCollection::class)->get()->loadFixtures([TestFixtures::class]);
    }
    public function testProjectPage()
    {
        $client = static::createClient();
        $this->loadFixtures();

        $crawler = $client->request('GET', '/project/un-projet');
        $this->assertResponseIsSuccessful();

        $this->assertSelectorTextContains('h1', "un projet");
        $this->assertSelectorTextContains('.description', "une super description de pour un projet de test");
    }
}
