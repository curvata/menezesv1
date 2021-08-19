<?php

namespace App\Entity;

use App\Repository\ProjectRepository;
use Cocur\Slugify\Slugify;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=ProjectRepository::class)
 */
class Project
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private ?int $id = null;

    /**
     * @ORM\Column(type="datetime")
     */
    private DateTime $createdAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private DateTime $updatedAt;

    /**
     * @ORM\Column(type="string", length=255)
     */
    #[assert\NotBlank(message: "Merci de renseigner un titre")]
    #[assert\Length(
        min: 4, 
        max: 50, 
        minMessage: "Merci de renseigner un titre de minimum {{ limit }} caractères",
        maxMessage: "Merci de renseigner un titre de maximum {{ limit }} caractères")]
    private string $title;

    /**
     * @ORM\Column(type="text", length=500)
     */
    #[assert\NotBlank(message: "Merci de renseigner une description")]
    #[assert\Length(
        min: 20, 
        max: 500, 
        minMessage: "Merci de renseigner une description de minimum {{ limit }} caractères",
        maxMessage: "Merci de renseigner une description de maximum {{ limit }} caractères")]
    private string $description;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    #[assert\NotBlank(message: "Merci de renseigner une adresse web")]
    #[Assert\Regex(
        '#^https:[/]{2}[a-zA-Z0-9\-\s]+.menezes.be$#', 
        message: "Merci de renseigner une adresse web de type 'https://*.menezes.be'")]
    #[assert\Length(
        min: 22, 
        max: 80, 
        minMessage: "Merci de renseigner une adresse web de minimum {{ limit }} caractères",
        maxMessage: "Merci de renseigner une adresse web de maximum {{ limit }} caractères")]
    private string $linkWeb;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    #[assert\NotBlank(message: "Merci de renseigner une adresse web")]
    #[Assert\Regex(
        '#^https:[/]{2}github.com[/]{1}curvata[/]{1}[a-zA-Z0-9\-\s]+$#', 
        message: "Merci de renseigner une adresse web de type 'https://github.com/curvata/*'")]
    #[assert\Length(
        min: 22, 
        max: 100, 
        minMessage: "Merci de renseigner une adresse web de minimum {{ limit }} caractères",
        maxMessage: "Merci de renseigner une adresse web de maximum {{ limit }} caractères")]
    private string $linkGithub;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $headerImage;

    #[Assert\Image(
        mimeTypes: ["image/jpeg","image/png"],
        mimeTypesMessage: "Uniquement les formats jpeg et png sont acceptés"
    )]
    private File $headerImageFile;

    /**
     * @ORM\OneToMany(targetEntity=Picture::class, mappedBy="project")
     */
    private Collection $pictures;

    /**
     * @ORM\Column(type="string", length=255)
     */
    #[Assert\Regex('/^[a-zA-Z0-9\-\S]+$/', message: "Merci de renseigner un slug valide")]
    private string $slug;

    public function __construct()
    {
        $this->pictures = new ArrayCollection();
    }

    public function getHeaderImageFile(): File
    {
        return $this->headerImageFile;
    }

    public function setHeaderImageFile(File $file): self
    {
        $this->headerImageFile = $file;
        return $this;
    }

    public function __toString(): string
    {
        return $this->title;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCreatedAt(): ?DateTime
    {
        return $this->createdAt;
    }

    public function setCreatedAt(DateTime $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?DateTime
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?DateTime $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getLinkWeb(): ?string
    {
        return $this->linkWeb;
    }

    public function setLinkWeb(?string $linkWeb): self
    {
        $this->linkWeb = $linkWeb;

        return $this;
    }

    public function getLinkGithub(): ?string
    {
        return $this->linkGithub;
    }

    public function setLinkGithub(?string $linkGithub): self
    {
        $this->linkGithub = $linkGithub;

        return $this;
    }

    public function getHeaderImage(): ?string
    {
        return $this->headerImage;
    }

    public function setHeaderImage(string $headerImage): self
    {
        $this->headerImage = $headerImage;

        return $this;
    }

    /**
     * @return Collection|Picture[]
     */
    public function getPictures(): Collection
    {
        return $this->pictures;
    }

    public function addPicture(Picture $picture): self
    {
        if (!$this->pictures->contains($picture)) {
            $this->pictures[] = $picture;
            $picture->setProject($this);
        }

        return $this;
    }

    public function removePicture(Picture $picture): self
    {
        if ($this->pictures->removeElement($picture)) {
            // set the owning side to null (unless already changed)
            if ($picture->getProject() === $this) {
                $picture->setProject(null);
            }
        }

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = (new Slugify())->slugify($slug);

        return $this;
    }
}
