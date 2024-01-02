<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class LoginPageTest extends WebTestCase
{
    public function testLoginPageResponse(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/login');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorExists('#loginForm');
    }

    public function testLoginFormElements(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/login');

        $this->assertSelectorExists('input[name="email"]');
        $this->assertSelectorExists('input[name="password"]');
        $this->assertSelectorExists('button[type="submit"]');
    }

    public function testLoginWithValidCredentials(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/login');

        $testUserEmail = 'vincent@parrot.fr';
        $testUserPassword = 'studi2023';

        $form = $crawler->selectButton('Se connecter')->form();
        $client->submit($form, [
            'email' => $testUserEmail,
            'password' => $testUserPassword
        ]);

        $client->followRedirect();

        $this->assertTrue($client->getResponse()->isSuccessful());
        $this->assertEquals('/users', $client->getRequest()->getRequestUri());
        $this->assertResponseIsSuccessful();
        $this->assertSelectorNotExists('.alert-danger');
    }

    public function testLoginWithInvalidCredentials(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/login');

        $form = $crawler->selectButton('Se connecter')->form();
        $client->submit($form, [
            'email' => 'invalid@example.com',
            'password' => 'wrongpassword'
        ]);

        $this->assertResponseRedirects();
        $client->followRedirect();

        $this->assertSelectorExists('.alert-danger');
    }
}
