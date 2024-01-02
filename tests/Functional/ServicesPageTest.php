<?php

namespace App\Tests\Controller;

use Symfony\Component\DomCrawler\Crawler;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ServicesPageTest extends WebTestCase
{
    public function testServicesPageResponse(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/services');

        $this->assertResponseIsSuccessful();
    }

    public function testDisplayOfServices(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/services');

        $this->assertGreaterThan(0, $crawler->filter('.article-container')->count(), 'Aucun service affiché.');

        $serviceContainers = $crawler->filter('.article-container');
    }
}
