<?php

namespace App\Tests\Class;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class MailTest extends WebTestCase
{

    public function testMailIsSentAndContentIsOk()
    {
        $client = static::createClient([], ['MY_MAIL' => 'test@test.be']);
        $crawler = $client->request('GET', '/');
        $form = $crawler->selectButton('Envoyer')->form();

        $crawler = $client->submit($form, [
            'contact[name]' => 'un super nom',
            'contact[email]' => 'toto@tata.be',
            'contact[message]' => 'Bonjour, ceci est un message depuis le site internet !'
        ]);
        $this->assertEmailCount(1);
        $crawler = $client->followRedirect();
        $this->assertSelectorTextContains('.alert_success', 'Message bien envoyé');
    }
}
