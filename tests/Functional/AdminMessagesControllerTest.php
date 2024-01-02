<?php

namespace App\Tests\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class AdminMessagesControllerTest extends WebTestCase
{
    private function authenticateClient($client)
    {
        $crawler = $client->request('GET', '/login');
        $form = $crawler->selectButton('Se connecter')->form();
        $client->submit($form, ['email' => 'vincent@parrot.fr', 'password' => 'studi2023']);
        $client->followRedirect();
    }

    public function testMessagesList(): void
    {
        $client = static::createClient();
        $this->authenticateClient($client);

        $crawler = $client->request('GET', '/admin/messages');

        $this->assertResponseIsSuccessful();

        $this->assertSelectorExists('.table');

        $this->assertSelectorTextContains('td', 'Jager');
    }

    public function testDeleteMessage(): void
    {
        $client = static::createClient();
        $this->authenticateClient($client);
    
        $messageId = 30;
    
        $client->request('POST', '/admin/messages/delete/' . $messageId);
    
        $this->assertResponseRedirects('/admin/messages');
        $crawler = $client->followRedirect();
    
        $content = $crawler->filter('.table')->text();
        $this->assertStringNotContainsString('Jager', $content);
    }
    
    
}
