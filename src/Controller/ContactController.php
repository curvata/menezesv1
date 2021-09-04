<?php

namespace App\Controller;

use App\Class\Contact;
use App\Class\MyMailer;
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
    public function index(Request $request, MyMailer $mailer): RedirectResponse
    {
        $contact = new Contact();
        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $mailer->send($contact);
            } catch (Exception $e) {
                $this->addFlash("form_error", "Nous n'avons pas réussi à envoyer votre message, merci de réessayer ultérieurement !");
                return $this->redirect($request->server->get('HTTP_REFERER')."#contact");
            }
            $this->addFlash("form_success", "Message bien envoyé");

        } else {
            $this->addFlash("form_error", "Le formulaire comporte des erreurs !");
        }

        return $this->redirect($request->server->get('HTTP_REFERER')."#contact");
    }
}