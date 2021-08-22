<?php

namespace App\Tests\Entity;

use App\Entity\Project;
use App\Tests\Helper\GenerateText;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\Validator\ConstraintViolationList;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ProjectEntityTest extends KernelTestCase
{
    use GenerateText;
    
    public function valid(mixed $project): ConstraintViolationList
    {
        self::bootKernel();
        /** @var ValidatorInterface */
        return self::getContainer()->get('debug.validator')->validate($project);
    }

    public function getProject(): Project
    {
        return (new Project())
            ->setSlug("mon projet")
            ->setTitle("Un titre")
            ->setDescription("Une description pour mon projet")
            ->setLinkWeb("https://monprojet.menezes.be")
            ->setLinkGithub("https://github.com/curvata/monprojet");
    }
    public function testProjectValid(): void
    {
        $this->assertCount(0, $this->valid($this->getProject()));
    }

    public function testTitleNotValid(): void
    {
        $project = $this->getProject();

        $project->setTitle("tit");
        $this->assertCount(1, $this->valid($project));
        $this->assertStringContainsString(
            "Merci de renseigner un titre de minimum 4 caractères", $this->valid($project)[0]->getMessage());

        $project->setTitle($this->getString(51));
        $this->assertCount(1, $this->valid($project));
        $this->assertStringContainsString(
            "Merci de renseigner un titre de maximum 50 caractères", $this->valid($project)[0]->getMessage());
    }

    public function testDescriptionNotValid(): void
    {
        $project = $this->getProject();

        $project->setDescription("Une description");
        $this->assertCount(1, $this->valid($project));
        $this->assertStringContainsString(
            "Merci de renseigner une description de minimum 20 caractères", $this->valid($project)[0]->getMessage());

        $project->setDescription($this->getString(501));
        $this->assertCount(1, $this->valid($project));
        $this->assertStringContainsString(
            "Merci de renseigner une description de maximum 500 caractères", $this->valid($project)[0]->getMessage());
    }

    public function testLinkWebNotValid(): void
    {
        $project = $this->getProject();

        $project->setLinkWeb("");
        $this->assertCount(2, $this->valid($project));
        $this->assertStringContainsString(
            "Merci de renseigner une adresse web", $this->valid($project)[0]->getMessage());
        $this->assertStringContainsString(
            "Merci de renseigner une adresse web de minimum 22 caractères", $this->valid($project)[1]->getMessage());

        $project->setLinkWeb("https://".$this->getString(80).".menezes.be");
        $this->assertCount(1, $this->valid($project));
        $this->assertStringContainsString(
            "Merci de renseigner une adresse web de maximum 80 caractères", $this->valid($project)[0]->getMessage());
        
        $project->setLinkWeb("https://monproject.monsite.be");
        $this->assertCount(1, $this->valid($project));
        $this->assertStringContainsString(
            "Merci de renseigner une adresse web de type 'https://*.menezes.be'", $this->valid($project)[0]->getMessage());
     }

    public function testLinkGithubNotValid(): void
    {
        $project = $this->getProject();

        $project->setLinkGithub("");
        $this->assertCount(2, $this->valid($project));
        $this->assertStringContainsString(
            "Merci de renseigner une adresse web", $this->valid($project)[0]->getMessage());
        $this->assertStringContainsString(
            "Merci de renseigner une adresse web de minimum 22 caractères", $this->valid($project)[1]->getMessage());

        $project->setLinkGithub("https://github.com/curvata/".$this->getString(100));
        $this->assertCount(1, $this->valid($project));
        $this->assertStringContainsString(
            "Merci de renseigner une adresse web de maximum 100 caractères", $this->valid($project)[0]->getMessage());
        
        $project->setLinkGithub("https://github.com/monprofil/monprojet");
        $this->assertCount(1, $this->valid($project));
        $this->assertStringContainsString(
            "Merci de renseigner une adresse web de type 'https://github.com/curvata/*'", $this->valid($project)[0]->getMessage());
     }

    public function testSlug(): void
    {
        $project = $this->getProject();

        $project->setSlug("mon superbe projet");
        $this->assertCount(0, $this->valid($project));
        $this->assertStringContainsString("mon-superbe-projet", $project->getSlug());
    }

    public function testFileHeaderValid()
    {
        $file = new File(dirname(__DIR__)."/FilesTest/test.jpg");

        $project = $this->getProject();
        $project->setHeaderImageFile($file);

        $this->assertCount(0, $this->valid($project));
    }

    public function testFileHeaderNotValid(): void
    {
        $file = new File(dirname(__DIR__)."/FilesTest/test.pdf");

        $project = $this->getProject();
        $project->setHeaderImageFile($file);

        $this->assertCount(1, $this->valid($project));
        $this->assertStringContainsString("Uniquement les formats jpeg et png sont acceptés", $this->valid($project)[0]->getMessage());
    }
}
