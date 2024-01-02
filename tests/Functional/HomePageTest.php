<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class HomePageTest extends WebTestCase
{

  public function testIndex(): void
  {
    $client = static::createClient();
    $crawler = $client->request('GET', '/');
  
    $this->assertResponseIsSuccessful();

    $this->assertSelectorExists('#reviewCarousel .carousel-item');

    $this->assertSelectorExists('script[src="/assets/javascript/saveStarsValue.js"]');
    $this->assertSelectorExists('script[src="/assets/javascript/limitCharacters175.js"]');

    $linkToServices = $crawler->filter('a[href="/services"]')->link();
    $crawler = $client->click($linkToServices);
    $this->assertResponseIsSuccessful();

    $linkToUsedCars = $crawler->filter('a[href="/occasions"]')->link();
    $crawler = $client->click($linkToUsedCars);
    $this->assertResponseIsSuccessful();
  }
  
  public function testReviewFormSubmission(): void
  {
    $client = static::createClient();
    $crawler = $client->request('GET', '/');

    $this->assertResponseIsSuccessful();

    $form = $crawler->selectButton('Envoyer l\'avis')->form();

    $formData = [
      'lastname' => 'Doe',
      'firstname' => 'John',
      'subject' => '21',
      'comment' => 'Ceci est un commentaire test.',
      'ratingValue' => '5',
    ];

    $client->submit($form, $formData);

    $this->assertResponseRedirects();
    $client->followRedirect();
  }

  public function testReviewFormSubmissionWithIncompleteData(): void
  {
    $client = static::createClient();
    $crawler = $client->request('GET', '/');

    $this->assertResponseIsSuccessful();

    $form = $crawler->selectButton('Envoyer l\'avis')->form();

    $formData = [
      'lastname' => 'Doe',
      // 'firstname' isn't provided
      'subject' => '21',
      // 'comment' isn't provided
      // 'ratingValue' isn't provided
    ];

    $client->submit($form, $formData);

    $this->assertResponseStatusCodeSame(200);

    $this->assertResponseIsSuccessful();
  }

  public function testReviewFormSubmissionWithInvalidData(): void
  {
    $client = static::createClient();
    $crawler = $client->request('GET', '/');

    $this->assertResponseIsSuccessful();

    $form = $crawler->selectButton('Envoyer l\'avis')->form();

    $formData = [
      'lastname' => '', // Empty name
      'firstname' => 'John',
      'subject' => '21',
      'comment' => 'Ceci est un commentaire test.',
      'ratingValue' => '6', // Invalid rating value
    ];

    $client->submit($form, $formData);

    $this->assertResponseStatusCodeSame(200);

    $this->assertResponseIsSuccessful();
  }

  public function testReviewFormFieldLengths(): void
  {
    $client = static::createClient();
    $crawler = $client->request('GET', '/');

    $this->assertResponseIsSuccessful();

    $this->assertSame('50', $crawler->filter('input[name="lastname"]')->attr('maxlength'));
    $this->assertSame('50', $crawler->filter('input[name="firstname"]')->attr('maxlength'));
    $this->assertSame('175', $crawler->filter('textarea[name="comment"]')->attr('maxlength'));
  }
}