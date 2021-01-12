<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class RoomControllerTest extends WebTestCase
{
    public function testIndex()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/admin');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());

        $this->assertEquals(1, $crawler->filter('a:contains("Creer une nouvelle Room")')->count());
        $crawler2 =$crawler;
        $link = $crawler
            ->filter('a:contains("Editer")') // find all links with the text
            ->eq(0) // select the fisrt link in the list
            ->link();
        // and click it
        $crawler = $client->click($link);
        $this->assertGreaterThan(3, $crawler->filter('input')->count());
        $this->assertEquals(1, $crawler->filter('h1:contains("Editer la Room")')->count());

        $link = $crawler2
            ->filter('a:contains("Creer une nouvelle Room")') // find all links with the text
            ->eq(0) // select the fisrt link in the list
            ->link();
        // and click it
        $crawler = $client->click($link);
        $this->assertGreaterThan(3, $crawler->filter('input')->count());
    }

    public function testNew()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/admin/room/create');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());

        $this->assertEquals(1, $crawler->filter('h1:contains("Ajouter une Room")')->count());

        $this->assertGreaterThan(3, $crawler->filter('input')->count());
    }

    public function testEdit()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/admin');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());

        $link = $crawler
            ->filter('a:contains("Editer")') // find all links with the text
            ->eq(0) // select the fisrt link in the list
            ->link();
        // and click it
        $crawler = $client->click($link);
        $this->assertGreaterThan(3, $crawler->filter('input')->count());
        $this->assertEquals(1, $crawler->filter('h1:contains("Editer la Room")')->count());
    }

    public function testDelete()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/admin');

        $form = $crawler->selectButton('Supprimer')->form();
        // submit the form
        $crawler = $client->submit($form);

        $this->assertResponseRedirects('/admin');

        $crawler = $client->followRedirect();

        // asserts that the response matches a given CSS selector.
        $this->assertEquals(1, $crawler->filter('.alert')->count());

        $this->assertEquals(1, $crawler->filter('.alert:contains("Room supprimé avec success")')->count());
    }
}