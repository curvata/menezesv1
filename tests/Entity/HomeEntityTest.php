<?php

namespace App\Tests;

use App\Entity\Home;
use App\Tests\Helper\GenerateText;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\ConstraintViolationList;

class HomeEntityTest extends KernelTestCase
{
    use GenerateText;
    
    public function valid(mixed $project): ConstraintViolationList
    {
        self::bootKernel();
        /** @var ValidatorInterface */
        return self::getContainer()->get('debug.validator')->validate($project);
    }

    public function getHome(): Home
    {
        return (new Home())
            ->setIntro($this->getString(50))
            ->setAboutMe($this->getString(300));
    }

    public function testHomeValid(): void
    {
        $this->assertCount(0, $this->valid($this->gethome()));
    }

    public function testIntroNotValid()
    {
        $intro = $this->getHome();
        $intro->setIntro("");

        $errors = $this->valid($intro);

        $this->assertCount(2, $errors);
        $this->assertStringContainsString("Merci de renseigner un texte d'introduction", $errors[0]->getMessage());
        $this->assertStringContainsString("Merci de renseigner un texte d'introduction de minimum 25 caractères", $errors[1]->getMessage());

        $intro->setIntro($this->getString(55));
        $errors = $this->valid($intro);

        $this->assertStringContainsString("Merci de renseigner un texte d'introduction de maximum 50 caractères", $errors[0]->getMessage());
    }

    public function testAboutMeNotValid()
    {
        $intro = $this->getHome();
        $intro->setAboutMe("");

        $errors = $this->valid($intro);

        $this->assertCount(2, $errors);
        $this->assertStringContainsString("Merci de renseigner un texte à propos", $errors[0]->getMessage());
        $this->assertStringContainsString("Merci de renseigner un texte à propos de minimum 50 caractères", $errors[1]->getMessage());

        $intro->setAboutMe($this->getString(301));
        $errors = $this->valid($intro);

        $this->assertStringContainsString("Merci de renseigner un texte à propos de maximum 300 caractères", $errors[0]->getMessage());
    }

    public function testPictureValid()
    {
        $file = new File(dirname(__DIR__)."/FilesTest/test.jpg");

        $home = $this->getHome();
        $home->setPictureFile($file);

        $this->assertCount(0, $this->valid($home));
    }

    public function testPictureNotValid()
    {
        $file = new File(dirname(__DIR__)."/FilesTest/test.pdf");

        $home = $this->getHome();
        $home->setPictureFile($file);

        $errors = $this->valid($home);

        $this->assertCount(1, $errors);
        $this->assertStringContainsString("Uniquement les formats jpeg et png sont acceptés", $errors[0]->getMessage());
    }
}
