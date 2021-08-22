<?php

namespace App\Class;

use Symfony\Component\Validator\Constraints as assert;

class Contact
{
    #[assert\NotBlank(message: "Merci de renseigner un email")]
    #[assert\Email(message: "Merci de renseigner une adresse email valide")]
    private string $mail;

    #[assert\NotBlank(message: "Merci de renseigner un nom")]
    #[assert\Length(
        min: 5, 
        max: 30, 
        minMessage: "Merci de renseigner un nom de minimum {{ limit }} caractères",
        maxMessage: "Merci de renseigner un nom de maximum {{ limit }} caractères")]
    private string $name;

    #[assert\NotBlank(message: "Vous avez oublié d'écrire un message")]
    #[assert\Length(
        min: 20, 
        max: 200, 
        minMessage: "Merci de renseigner un message de minimum {{ limit }} caractères",
        maxMessage: "Merci de renseigner un message de maximum {{ limit }} caractères")]
    private string $message;

    public function setMail(string $mail): self
    {
        $this->mail = $mail;
        return $this;
    }

    public function getMail(): ?string
    {
        return $this->mail;
    }

    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setMessage(string $message): self
    {
        $this->message = $message;
        return $this;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }
    
}
