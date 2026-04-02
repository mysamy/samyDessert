<?php

namespace App\Tests\Controller;

use App\Factory\UtilisateurFactory;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Zenstruck\Foundry\Test\Factories;
use Zenstruck\Foundry\Test\ResetDatabase;

class ConnexionControllerTest extends WebTestCase
{
    use ResetDatabase, Factories;

    public function testGetConnexion(): void
    {
        $client = static::createClient();
        $client->request('GET', '/connexion');
        $this->assertResponseIsSuccessful();
        $this->assertSelectorExists('form');
    }

    public function testConnexionMauvaisMotDePasse(): void
    {
        $client = static::createClient();
        UtilisateurFactory::createOne(['email' => 'jean@test.com']);

        $crawler = $client->request('GET', '/connexion');
        $client->submit($crawler->selectButton('Se connecter')->form([
            'email'    => 'jean@test.com',
            'password' => 'mauvais_mot_de_passe',
        ]));
        $client->followRedirect();

        $this->assertSelectorExists('.alert-danger, [class*="error"], [class*="danger"]');
    }

    public function testConnexionValide(): void
    {
        $client = static::createClient();
        UtilisateurFactory::createOne(['email' => 'jean@test.com']);

        $crawler = $client->request('GET', '/connexion');
        $client->submit($crawler->selectButton('Se connecter')->form([
            'email'    => 'jean@test.com',
            'password' => 'motdepasse123',
        ]));

        $this->assertResponseRedirects('/');
    }
}
