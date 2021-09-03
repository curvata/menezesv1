<?php

namespace App\Controller\Admin;

use App\Entity\Project;
use App\Form\ProjectType;
use App\Repository\ProjectRepository;
use DateTime;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/project')]
class AdminProjectController extends AbstractController
{
    /**
     * Index des projets
     */
    #[Route('/', name: 'admin.project.index', methods: ['GET'])]
    public function index(ProjectRepository $projectRepository): Response
    {
        return $this->render('admin/project/index.html.twig', [
            'projects' => $projectRepository->findAll(),
        ]);
    }

    /**
     * Créer un projet
     */
    #[Route('/new', name: 'admin.project.new', methods: ['GET', 'POST'])]
    public function new(Request $request): Response
    {
        $project = new Project();
        $form = $this->createForm(ProjectType::class, $project);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($project);
            $entityManager->flush();

            $this->addFlash('success', 'La destination '. $project->getTitle() . ' a bien été créée');
            return $this->redirectToRoute('admin.project.index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/project/new.html.twig', [
            'project' => $project,
            'form' => $form,
        ]);
    }

    /**
     * Visualiser un projet
     */
    #[Route('/{id}', name: 'admin.project.show', methods: ['GET'])]
    public function show(Project $project): Response
    {
        return $this->render('admin/project/show.html.twig', [
            'project' => $project,
        ]);
    }

    /**
     * Editer un projet
     */
    #[Route('/edit/{id}', name: 'admin.project.edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Project $project): Response
    {
        $form = $this->createForm(ProjectType::class, $project);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $project->setUpdatedAt(new DateTime());

            $this->getDoctrine()->getManager()->flush();

            $this->addFlash('success', 'La destination '. $project->getTitle() . ' a bien été mise à jour');
            return $this->redirectToRoute('admin.project.index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/project/edit.html.twig', [
            'project' => $project,
            'form' => $form,
        ]);
    }

    /**
     * Supprimer un projet
     */
    #[Route('/{id}', name: 'admin.project.delete', methods: ['POST'])]
    public function delete(Request $request, Project $project): Response
    {
        $path = 'images/projets/';

        if ($this->isCsrfTokenValid('delete'.$project->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();

            try {
                $entityManager->remove($project);
                $entityManager->flush();
            } catch (Exception $e) {
                $this->addFlash('error', 'Impossible de supprimer la destination '. $project->getTitle() . ' car elle est liée à des vols de départs et de retours');
                return $this->redirectToRoute('admin.project.index');
            }

            $this->addFlash('success', 'La destination '. $project->getTitle() . ' a bien été supprimée');

            if ($project->getHeaderImage() != 'placeholder.png'
                && file_exists($path.$project->getHeaderImage())
            ) {
                unlink($path.$project->getHeaderImage());
            }
            foreach ($project->getPictures() as $picture) {
                if (file_exists($path.'small_'.$picture->getfilename())) {
                    unlink($path.$picture->getfilename());
                    unlink($path.'small_'.$picture->getfilename());
                }
            }
        }


        return $this->redirectToRoute('admin.project.index', [], Response::HTTP_SEE_OTHER);
    }
}
