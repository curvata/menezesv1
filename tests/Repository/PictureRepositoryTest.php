<?php

namespace App\Repository;

use App\DataFixtures\TestFixtures;
use Liip\TestFixturesBundle\Services\DatabaseToolCollection;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class PictureRepositoryTest extends WebTestCase
{
    public function loadFixtures()
    {
        self::getContainer()->get(DatabaseToolCollection::class)->get()->loadFixtures([TestFixtures::class]);
    }

    public function testFindAll()
    {
        $this->loadFixtures();
        $pictures = static::getContainer()->get(PictureRepository::class)->findAll();

        $this->assertCount(1, $pictures);
        $this->assertStringContainsString("picture.jpeg", $pictures[0]->getFilename());
    }
}
