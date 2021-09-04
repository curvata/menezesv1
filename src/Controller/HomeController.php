<?php

namespace App\Controller;

use App\Class\Contact;
use App\Form\ContactType;
use App\Repository\ProjectRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * Page d'accueil
     */
    #[Route('/', name: 'home', methods: ['GET'])]    
    public function index(ProjectRepository $projectRepo): Response
    {
        return $this->render('home.html.twig', ['projects' => $projectRepo->findAll()]);
    }
}