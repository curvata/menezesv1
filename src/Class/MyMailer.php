<?php

namespace App\Class;

use Exception;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Mailer\MailerInterface;

class MyMailer
{
    private Request $request;
    private MailerInterface $mailer;

    public function __construct(RequestStack $request, MailerInterface $mailer)
    {
        $this->request = $request->getCurrentRequest();
        $this->mailer = $mailer;
    }

    /**
     * Envoyer un mail
     */
    public function send(Contact $contact): void
    {
        try {
            $email = (new TemplatedEmail())
                ->from($this->request->server->get('MY_MAIL'))
                ->to($this->request->server->get('MY_MAIL'))
                ->subject("Contact depuis le formulaire de menezes.be")
                ->htmlTemplate("mail/contact.html.twig")
                ->context(
                    [
                        'message' => $contact->getMessage(),
                        'name' => $contact->getName(),
                        'mail' => $contact->getEmail()
                        ]
                );
            $this->mailer->send($email);
        } catch (Exception $e) {
            throw new Exception("Impossible d'envoyer l'e-mail (" . $e . ")");
        }
    }
}
