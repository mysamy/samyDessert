<?php

namespace App\Tests\Controller;

use App\Factory\UtilisateurFactory;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Zenstruck\Foundry\Test\Factories;
use Zenstruck\Foundry\Test\ResetDatabase;

class CompteControllerTest extends WebTestCase
{
    use ResetDatabase, Factories;

    public function testMonCompteRedirigeVersConnexionSiNonConnecte(): void
    {
        $client = static::createClient();
        $client->request('GET', '/mon-compte');
        $this->assertResponseRedirects('/connexion');
    }

    public function testMonCompteAffichePageConnecte(): void
    {
        $client = static::createClient();
        $user   = UtilisateurFactory::createOne(['email' => 'compte@test.com']);
        $client->loginUser($user);
        $client->request('GET', '/mon-compte');
        $this->assertResponseIsSuccessful();
    }

    public function testMonCompteAfficheEmail(): void
    {
        $client = static::createClient();
        $user   = UtilisateurFactory::createOne(['email' => 'compte@test.com']);
        $client->loginUser($user);
        $client->request('GET', '/mon-compte');
        $this->assertSelectorTextContains('body', 'compte@test.com');
    }
}
