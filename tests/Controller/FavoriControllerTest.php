<?php

namespace App\Tests\Controller;

use App\Factory\ProduitFactory;
use App\Factory\UtilisateurFactory;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Zenstruck\Foundry\Test\Factories;
use Zenstruck\Foundry\Test\ResetDatabase;

class FavoriControllerTest extends WebTestCase
{
    use ResetDatabase, Factories;

    // --- Sans connexion ---

    public function testToggleSansConnexionRetourne401(): void
    {
        $client = static::createClient();
        $client->request('POST', '/favori/produit/1', [], [], [
            'HTTP_X-Requested-With' => 'XMLHttpRequest',
        ]);
        $this->assertResponseStatusCodeSame(401);
        $data = json_decode($client->getResponse()->getContent(), true);
        $this->assertArrayHasKey('error', $data);
    }

    // --- Sans header AJAX ---

    public function testToggleSansHeaderAjaxRetourne400(): void
    {
        $client  = static::createClient();
        $user    = UtilisateurFactory::createOne();
        $produit = ProduitFactory::createOne();
        $client->loginUser($user);

        $client->request('POST', '/favori/produit/' . $produit->getId());
        $this->assertResponseStatusCodeSame(400);
    }

    // --- Type invalide ---

    public function testToggleTypeInvalideRetourne400(): void
    {
        $client = static::createClient();
        $user   = UtilisateurFactory::createOne();
        $client->loginUser($user);

        $client->request('POST', '/favori/inexistant/1', [], [], [
            'HTTP_X-Requested-With' => 'XMLHttpRequest',
        ]);
        $this->assertResponseStatusCodeSame(400);
    }

    // --- Produit introuvable ---

    public function testToggleProduitInexistantRetourne404(): void
    {
        $client = static::createClient();
        $user   = UtilisateurFactory::createOne();
        $client->loginUser($user);

        $client->request('POST', '/favori/produit/99999', [], [], [
            'HTTP_X-Requested-With' => 'XMLHttpRequest',
        ]);
        $this->assertResponseStatusCodeSame(404);
    }

    // --- Toggle produit favori ---

    public function testToggleProduitAjouteFavori(): void
    {
        $client  = static::createClient();
        $user    = UtilisateurFactory::createOne();
        $produit = ProduitFactory::createOne();
        $client->loginUser($user);

        $client->request('POST', '/favori/produit/' . $produit->getId(), [], [], [
            'HTTP_X-Requested-With' => 'XMLHttpRequest',
        ]);

        $this->assertResponseIsSuccessful();
        $data = json_decode($client->getResponse()->getContent(), true);
        $this->assertTrue($data['favori']); // premier toggle → ajout
    }

    public function testToggleProduitDeuxFoisRetireLesFavoris(): void
    {
        $client  = static::createClient();
        $user    = UtilisateurFactory::createOne();
        $produit = ProduitFactory::createOne();
        $client->loginUser($user);

        $headers = ['HTTP_X-Requested-With' => 'XMLHttpRequest'];

        // Premier toggle → ajout
        $client->request('POST', '/favori/produit/' . $produit->getId(), [], [], $headers);
        $data = json_decode($client->getResponse()->getContent(), true);
        $this->assertTrue($data['favori']);

        // Deuxième toggle → retrait
        $client->request('POST', '/favori/produit/' . $produit->getId(), [], [], $headers);
        $data = json_decode($client->getResponse()->getContent(), true);
        $this->assertFalse($data['favori']);
    }

    public function testToggleProduitRetourneJson(): void
    {
        $client  = static::createClient();
        $user    = UtilisateurFactory::createOne();
        $produit = ProduitFactory::createOne();
        $client->loginUser($user);

        $client->request('POST', '/favori/produit/' . $produit->getId(), [], [], [
            'HTTP_X-Requested-With' => 'XMLHttpRequest',
        ]);

        $this->assertResponseHeaderSame('content-type', 'application/json');
        $data = json_decode($client->getResponse()->getContent(), true);
        $this->assertArrayHasKey('favori', $data);
        $this->assertIsBool($data['favori']);
    }

    // --- Connexion bloquée si compte non vérifié ---

    public function testConnexionBloqueeSiCompteNonVerifie(): void
    {
        $client = static::createClient();
        UtilisateurFactory::createOne([
            'email'      => 'nonverifie@test.com',
            'isVerified' => false,
        ]);

        $crawler = $client->request('GET', '/connexion');
        $client->submit($crawler->selectButton('Se connecter')->form([
            'email'    => 'nonverifie@test.com',
            'password' => 'motdepasse123',
        ]));
        $client->followRedirect();

        $this->assertSelectorTextContains('body', 'activé');
    }
}
