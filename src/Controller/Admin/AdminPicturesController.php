<?php

namespace App\Controller\Admin;

use App\Entity\Location;
use App\Entity\Picture;
use App\Entity\Project;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class AdminPicturesController extends AbstractController
{
    private EntityManagerInterface $manager;

    public function __construct(EntityManagerInterface $manager)
    {
        $this->manager = $manager;
    }

    /**
     * Retourne les miniatures du projet
     */
    #[Route('/admin/pictures/project/{id}', name: 'admin.project.show.pictures', requirements: ["id" => "\d+"], methods: ['GET'])]
    public function getPictures(Project $project): JsonResponse
    {
        $pictures = $project->getPictures()->getValues();

        $array = [];

        foreach ($pictures as $key => $picture) {
            $array[$key][] = $picture->getId();
            $array[$key][] = $picture->getSmallPicture();
        }

        return new JsonResponse($array);
    }

    /**
     * Supprimer l'image du projet concernée
     */
    #[Route('/admin/pictures/project/delete/{id}', name: 'admin.project.remove.pictures', requirements: ["id" => "\d+"], methods: ["DELETE"])]
    public function removePicture(Picture $Picture): JsonResponse
    {
        if ($Picture->getFilename()) {
            unlink('images/projets/' . $Picture->getFilename());
            unlink('images/projets/small_' . $Picture->getFilename());
            $this->manager->remove($Picture);
            $this->manager->flush();
        }

        return new JsonResponse(null, 200);
    }
}
