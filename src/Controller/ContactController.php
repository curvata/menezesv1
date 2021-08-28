<?php

namespace App\Controller;

use App\Class\Contact;
use App\Form\ContactType;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends AbstractController
{
    /**
     * Formulaire de contact
     */
    #[Route('/contact', name: 'contact', methods: ['POST'])]    
    public function index(Request $request): RedirectResponse
    {
        $data = $request->request->all();
        $contact = new Contact();
        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $this->addFlash("success", "Message bien envoyé");

        } else {
            $this->addFlash("error", "Le formulaire comporte des erreurs !");
        }

        return $this->redirect($request->server->get('HTTP_REFERER')."#contact");
    }
}