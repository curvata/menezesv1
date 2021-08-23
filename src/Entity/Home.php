<?php

namespace App\Entity;

use App\Repository\HomeRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=HomeRepository::class)
 */
class Home
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private ?int $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    #[assert\NotBlank(message: "Merci de renseigner un texte d'introduction")]
    #[assert\Length(
        min: 25, 
        max: 50, 
        minMessage: "Merci de renseigner un texte d'introduction de minimum {{ limit }} caractères",
        maxMessage: "Merci de renseigner un texte d'introduction de maximum {{ limit }} caractères")]
    private string $intro;

    /**
     * @ORM\Column(type="string", length=255)
     */
    #[assert\NotBlank(message: "Merci de renseigner un texte à propos")]
    #[assert\Length(
        min: 50, 
        max: 300, 
        minMessage: "Merci de renseigner un texte à propos de minimum {{ limit }} caractères",
        maxMessage: "Merci de renseigner un texte à propos de maximum {{ limit }} caractères")]
    private string $aboutMe;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $picture;

    #[Assert\Image(
        mimeTypes: ["image/jpeg","image/png"],
        mimeTypesMessage: "Uniquement les formats jpeg et png sont acceptés"
    )]
    private File $pictureFile;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIntro(): ?string
    {
        return $this->intro;
    }

    public function setIntro(string $intro): self
    {
        $this->intro = $intro;

        return $this;
    }

    public function getAboutMe(): ?string
    {
        return $this->aboutMe;
    }

    public function setAboutMe(string $aboutMe): self
    {
        $this->aboutMe = $aboutMe;

        return $this;
    }

    public function getPicture(): ?string
    {
        return $this->picture;
    }

    public function setPicture(string $picture): self
    {
        $this->picture = $picture;

        return $this;
    }

    /**
     * Get the value of pictureFile
     */ 
    public function getPictureFile()
    {
        return $this->pictureFile;
    }

    /**
     * Set the value of pictureFile
     *
     * @return  self
     */ 
    public function setPictureFile($pictureFile)
    {
        $this->pictureFile = $pictureFile;

        return $this;
    }
}
