<?php

namespace App\Tests\Entity;

use App\Entity\Picture;
use App\Entity\Project;
use App\Tests\Helper\GenerateText;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\ConstraintViolationList;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class PictureTest extends KernelTestCase
{
    use GenerateText;

    public function valid(mixed $project): ConstraintViolationList
    {
        self::bootKernel();
        /** @var ValidatorInterface */
        return self::getContainer()->get('debug.validator')->validate($project);
    }

    /**
     * @return Picture
     */
    public function getEntity(): Picture
    {
        $file = new File(dirname(__DIR__, 1) . '/FilesTest/test.jpg');
        return (new Picture())
                ->setFilename('picture.jpeg')
                ->setPictureFile($file)
                ->setProject(new Project());
    }

    public function testValid()
    {
         $picture = $this->getEntity();
         $this->assertStringContainsString('small_picture.jpeg', $picture->getSmallPicture());
    }

    public function testSmallPicture()
    {
        $picture = $this->getEntity();
        $this->assertStringContainsString(
            "picture.jpeg",
            $picture->getFilename()
        );
    }

    public function testPicture()
    {
        $file = new File(dirname(__DIR__, 1) . '/FilesTest/test.jpg');
        $picture = $this->getEntity();
        $picture->setPictureFile($file);
        $this->assertThat($file, $this->equalTo($picture->getPictureFile()));
    }

    public function testProject()
    {
        $picture = $this->getEntity();
        $picture->setProject((new Project())->setTitle('un projet'));
        $this->assertStringContainsString('un projet', $picture->getProject()->getTitle());
    }
}
