<?php

namespace App\Tests\Controller;

use App\DataFixtures\TestFixtures;
use App\Repository\ProjectRepository;
use App\Repository\UserRepository;
use Liip\TestFixturesBundle\Services\DatabaseToolCollection;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ProjectAdminTest extends WebTestCase
{
    public function loadFixtures()
    {
        self::getContainer()->get(DatabaseToolCollection::class)->get()->loadFixtures([TestFixtures::class]);
    }
    public function testNewProject()
    {
        $client = static::createClient();
        $this->loadFixtures();
        $userRepository = static::getContainer()->get(UserRepository::class);
        $testUser = $userRepository->findOneByEmail('mail@mail.be');
        $client->loginUser($testUser);
        $crawler = $client->request('GET', '/admin/project/new');
        $this->assertResponseIsSuccessful();
        $form = $crawler->selectButton('Créer')->form();
        $form['project[title]'] = 'un projet2';
        $form['project[description]'] = 'une super description pour un projet2';
        $form['project[linkWeb]'] = 'projet2.menezes.be';
        $form['project[linkGithub]'] = 'curvata/projet2';
        $client->submit($form);
        $client->followRedirect();
        $this->assertSelectorTextContains('.alert_success', "La destination un projet2 a bien été créé");
        $projectsRepo = static::getContainer()->get(ProjectRepository::class);
        $this->assertStringContainsString('une super description pour un projet2', $projectsRepo->findOneByTitle('un projet2')->getDescription());
    }

    public function testEditProject()
    {
        $client = static::createClient();
        $this->loadFixtures();
        $userRepository = static::getContainer()->get(UserRepository::class);
        $testUser = $userRepository->findOneByEmail('mail@mail.be');
        $client->loginUser($testUser);
        $crawler = $client->request('GET', '/admin/project/edit/1');
        $this->assertResponseIsSuccessful();
        $form = $crawler->selectButton('Sauvegarder')->form();
        $form['project[title]'] = 'un projet edit';
        $form['project[linkGithub]'] = 'curvata/projet3';
        $client->submit($form);
        $client->followRedirect();
        $this->assertSelectorTextContains('.alert_success', "La destination un projet edit a bien été mise à jour");
        $projectsRepo = static::getContainer()->get(ProjectRepository::class);
        $this->assertStringContainsString('curvata/projet3', $projectsRepo->findOneByTitle('un projet edit')->getLinkGithub());
    }

    public function testShowProject()
    {
        $client = static::createClient();
        $this->loadFixtures();
        $userRepository = static::getContainer()->get(UserRepository::class);
        $testUser = $userRepository->findOneByEmail('mail@mail.be');
        $client->loginUser($testUser);
        $crawler = $client->request('GET', '/admin/project/1');
        $this->assertResponseIsSuccessful();
        $this->assertEquals(
            1,
            $crawler->filter('td:contains("curvata/test")')->count()
        );
    }

    public function testDeleteProject()
    {
        $client = static::createClient();
        $this->loadFixtures();
        $userRepository = static::getContainer()->get(UserRepository::class);
        $testUser = $userRepository->findOneByEmail('mail@mail.be');
        $client->loginUser($testUser);
        $crawler = $client->request('GET', '/admin/project/1');
        $this->assertResponseIsSuccessful();
        $form = $crawler->selectButton('Supprimer')->form();
        $client->submit($form);
        $crawler = $client->followRedirect();
        $projectsRepo = static::getContainer()->get(ProjectRepository::class);
        $this->assertSelectorTextContains('.alert_success', "La destination un projet a bien été supprimée");
        $this->assertEquals(
            1,
            $crawler->filter('td:contains("Aucun projet")')->count()
        );
    }
}
