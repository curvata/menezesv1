<?php

namespace App\Class\Tests;

use App\Class\Contact;
use App\Tests\Helper\GenerateText;
use PHPUnit\Framework\TestCase;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Validator\ConstraintViolationList;

class ContactTest extends KernelTestCase
{
    use GenerateText;

    public function valid(mixed $contact): ConstraintViolationList
    {
        self::bootKernel();
        /** @var ValidatorInterface */
        return self::getContainer()->get('debug.validator')->validate($contact);
    }

    public function getContact(): Contact
    {
        return (new Contact())
            ->setName($this->getString(5))
            ->setEmail("mail@mail.be")
            ->setMessage($this->getString(21));
    }
    public function testContactValid(): void
    {
        $this->assertCount(0, $this->valid($this->getContact()));
    }

    public function testNameNotValid(): void
    {
        $contact = $this->getContact();
        $contact->setName("");
        $errors = $this->valid($contact);

        $this->assertCount(2, $errors);
        $this->assertStringContainsString("Merci de renseigner un nom", $errors[0]->getMessage());
        $this->assertStringContainsString("Merci de renseigner un nom de minimum 5 caractères", $errors[1]->getMessage());

        $contact->setName($this->getString(4));
        $errors = $this->valid($contact);

        $this->assertCount(1, $errors);
        $this->assertStringContainsString("Merci de renseigner un nom de minimum 5 caractères", $errors[0]->getMessage());

        $contact->setName($this->getString(51));
        $errors = $this->valid($contact);

        $this->assertCount(1, $errors);
        $this->assertStringContainsString("Merci de renseigner un nom de maximum 30 caractères", $errors[0]->getMessage());
    }

    public function testMailNotValid(): void
    {
        $contact = $this->getContact();
        $contact->setEmail("");
        $errors = $this->valid($contact);

        $this->assertCount(1, $errors);
        $this->assertStringContainsString("Merci de renseigner un email", $errors[0]->getMessage());

        $contact->setEmail("ergerggerg");
        $errors = $this->valid($contact);

        $this->assertCount(1, $errors);
        $this->assertStringContainsString("Merci de renseigner une adresse email valide", $errors[0]->getMessage());
    }

    public function testMessageNotValid(): void
    {
        $contact = $this->getContact();
        $contact->setMessage("");
        $errors = $this->valid($contact);

        $this->assertCount(2, $errors);
        $this->assertStringContainsString("Vous avez oublié d'écrire un message", $errors[0]->getMessage());
        $this->assertStringContainsString("Merci de renseigner un message de minimum 20 caractères", $errors[1]->getMessage());

        $contact->setMessage($this->getString(19));
        $errors = $this->valid($contact);

        $this->assertCount(1, $errors);
        $this->assertStringContainsString("Merci de renseigner un message de minimum 20 caractères", $errors[0]->getMessage());

        $contact->setMessage($this->getString(501));
        $errors = $this->valid($contact);

        $this->assertCount(1, $errors);
        $this->assertStringContainsString("Merci de renseigner un message de maximum 500 caractères", $errors[0]->getMessage());
    }
}
