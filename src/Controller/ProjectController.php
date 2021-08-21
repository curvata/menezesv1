<?php

namespace App\Controller;

use App\Entity\Project;
use App\Repository\ProjectRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ProjectController extends AbstractController
{
    /**
     * Présentation d'un projet
     */
    #[Route('/project/{slug}', name: 'project.show', methods: ['GET'])]    
    public function show(string $slug, ProjectRepository $projects) 
    {
        return $this->render('show.html.twig', ['project' => $projects->findOneBySlug($slug)]);
    }
}