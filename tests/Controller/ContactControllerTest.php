<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ContactControllerTest extends WebTestCase
{
    public function testGetContact(): void
    {
        $client = static::createClient();
        $client->request('GET', '/contact');
        $this->assertResponseIsSuccessful();
        $this->assertSelectorExists('form');
    }

    public function testPostContactRedirigue(): void
    {
        $client = static::createClient();
        $client->request('GET', '/contact');
        $token = $client->getCrawler()->filter('input[name="_token"]')->attr('value');

        $client->request('POST', '/contact', [
            'nom'     => 'Jean Dupont',
            'email'   => 'jean@example.com',
            'sujet'   => 'Test',
            'message' => 'Bonjour, ceci est un test.',
            '_token'  => $token,
        ]);
        $this->assertResponseRedirects('/contact');
    }
}
