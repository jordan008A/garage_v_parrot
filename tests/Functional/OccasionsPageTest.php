<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class UsedCarsPageTest extends WebTestCase
{
    public function testUsedCarsPageResponse(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/occasions');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorExists('#toggleFiltersBtn');
        $this->assertSelectorExists('#carListContainer');
    }

    public function testCarsListed(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/occasions');

        $this->assertGreaterThan(0, $crawler->filter('.card')->count(), 'Aucune voiture listée.');
    }
}
