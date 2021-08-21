<?php

namespace App\Controller;

use App\Entity\Project;
use App\Repository\ProjectRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    /**
     * Index des projets
     */
    #[Route('/admin', name: 'admin.index', methods: ['GET'])]    
    public function index(ProjectRepository $projects): Response
    {
        return $this->render('admin.html.twig', ['projects' => $projects->findAll()]);
    }

    /**
     * Voir un projet
     */
    #[Route('/admin/project/show/{id}', name: 'admin.project.show', methods: ['GET'])]
    public function show(Project $project): Response
    {
        return $this->render('project/show.html.twig', ['project' => $project]);
    }

    /**
     * Editer un projet
     */
    #[Route('/admin/project/edit/{id}', name: 'admin.project.edit', methods: ['GET', 'POST'])]
    public function edit(Project $project): Response
    {
        return $this->render('project/edit.html.twig', ['project' => $project]);
    }

    /**
     * Ajouter un projet
     */
    #[Route('/admin/project/new', name: 'admin.project.new', methods: ['GET', 'POST'])]
    public function new(): Response
    {
        return $this->render('project/new.html.twig');
    }
}