<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CarDetailsPageTest extends WebTestCase
{
    public function testCarDetailsPageResponse(): void
    {
        $client = static::createClient();
        $client->request('GET', '/occasions/018cb0e2-3df4-7056-866c-6c0b9f3fd990');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorExists('.carousel');
        $this->assertSelectorExists('.car-title');
        $this->assertSelectorExists('.car-text');
    }

    public function testJavaScriptAssets(): void
    {
        $client = static::createClient();
        $client->request('GET', '/occasions/018cb0e2-3df4-7056-866c-6c0b9f3fd990');

        $this->assertSelectorExists('script[src="/assets/javascript/updateDivHeight.js"]');
        $this->assertSelectorExists('script[src="/assets/javascript/limitCharacters255.js"]');
    }

    public function testCarDetailsInformation(): void
    {
        $client = static::createClient();
        $client->request('GET', '/occasions/018cb0e2-3df4-7056-866c-6c0b9f3fd990');

        $this->assertSelectorTextContains('.car-title', 'Golf VII GTI');
        $this->assertSelectorTextContains('.car-text', 'Volkswagen');
    }

    public function testContactForm(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/occasions/018cb0e2-3df4-7056-866c-6c0b9f3fd990');

        $this->assertSelectorExists('form.contact-details-form');
        $this->assertSelectorExists('input[name="subject"][readonly]');
    
        $this->assertSame('Golf VII GTI', $crawler->filter('input[name="subject"]')->attr('value'));
    }

    public function testCarouselImages(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/occasions/018cb0e2-3df4-7056-866c-6c0b9f3fd990');

        $this->assertSelectorExists('#carouselExampleControls');

        $this->assertGreaterThan(0, $crawler->filter('#carouselExampleControls .carousel-item img')->count(), 'Aucune image dans le carousel.');
    }
}
