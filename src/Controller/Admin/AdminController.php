<?php

namespace App\Controller\Admin;

use App\Entity\Project;
use App\Repository\ProjectRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    /**
     * Index de l'administration
     */
    #[Route('/admin', name: 'admin.index', methods: ['GET'])]    
    public function index(): Response
    {
        return $this->render('admin/admin.html.twig');
    }
}