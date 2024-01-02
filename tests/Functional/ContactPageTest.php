<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ContactPageTest extends WebTestCase
{
  public function testContactPageResponse(): void
  {
    $client = static::createClient();
    $crawler = $client->request('GET', '/contact');

    $this->assertResponseIsSuccessful();
    $this->assertSelectorExists('.contact-information');
    $this->assertSelectorExists('#wrapper-9cd199b9cc5410cd3b1ad21cab2e54d3');
    $this->assertSelectorExists('script[src="/assets/javascript/limitCharacters255.js"]');
  }

  public function testContactFormSubmission(): void
  {
    $client = static::createClient();
    $crawler = $client->request('GET', '/contact');

    $form = $crawler->selectButton('Envoyer un message')->form();
    $formData = [
      'lastname' => 'Jager',
      'firstname' => 'Eren',
      'email' => 'eren.jager@example.com',
      'phone' => '0600000000',
      'subject' => '21',
      'comment' => 'Ceci est un commentaire test.',
    ];

    $client->submit($form, $formData);
    $this->assertResponseRedirects();
  }

  public function testContactFormFieldLengths(): void
  {
    $client = static::createClient();
    $crawler = $client->request('GET', '/contact');

    $this->assertSame('50', $crawler->filter('input[name="lastname"]')->attr('maxlength'));
    $this->assertSame('50', $crawler->filter('input[name="firstname"]')->attr('maxlength'));
    $this->assertSame('255', $crawler->filter('textarea[name="comment"]')->attr('maxlength'));
  }

  public function testContactFormSubmissionWithIncompleteData(): void
  {
    $client = static::createClient();
    $crawler = $client->request('GET', '/contact');

    $form = $crawler->selectButton('Envoyer un message')->form();

    $formData = [
      'lastname' => 'Doe',
      'firstname' => '',
    ];

    $client->submit($form, $formData);
    $this->assertResponseStatusCodeSame(200);
  }

  public function testContactFormSubmissionWithInvalidData(): void
  {
    $client = static::createClient();
    $crawler = $client->request('GET', '/contact');
  
    $form = $crawler->selectButton('Envoyer un message')->form();

    $formData = [
      'lastname' => 'Doe',
      'firstname' => 'John',
      'email' => 'invalid-email',
      'phone' => 'invalid-phone',
      'subject' => '21',
      'comment' => 'Ceci est un commentaire test.',
    ];
  
    $client->submit($form, $formData);
  
    $this->assertResponseStatusCodeSame(200);
  }
}
