<?php

namespace App\Tests\Controller;

use App\Factory\ProduitFactory;
use App\Factory\UtilisateurFactory;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Zenstruck\Foundry\Test\Factories;
use Zenstruck\Foundry\Test\ResetDatabase;

class CommandeControllerTest extends WebTestCase
{
    use ResetDatabase, Factories;

    private function clientConnecte(): array
    {
        $client  = static::createClient();
        $user    = UtilisateurFactory::createOne(['email' => 'commande@test.com']);
        $produit = ProduitFactory::createOne(['prix' => '9.90']);
        $client->loginUser($user);
        return [$client, $produit->getId()];
    }

    // --- Sans connexion ---

    public function testAdresseRedirigeVersConnexionSiNonConnecte(): void
    {
        $client = static::createClient();
        $client->request('GET', '/commande/adresse');
        $this->assertResponseRedirects('/connexion');
    }

    public function testCommandeRedirigeVersConnexionSiNonConnecte(): void
    {
        $client = static::createClient();
        $client->request('GET', '/commande');
        $this->assertResponseRedirects('/connexion');
    }

    // --- Connecté, panier vide ---

    public function testAdresseRedirigeVersPanierSiPanierVide(): void
    {
        [$client] = $this->clientConnecte();
        $client->request('GET', '/commande/adresse');
        $this->assertResponseRedirects('/panier');
    }

    public function testCommandeRedirigeVersPanierSiPanierVide(): void
    {
        [$client] = $this->clientConnecte();
        $client->request('GET', '/commande');
        $this->assertResponseRedirects('/panier');
    }

    // --- Connecté, panier rempli ---

    public function testAdresseAfficheFormulaire(): void
    {
        [$client, $produitId] = $this->clientConnecte();
        $client->request('POST', '/panier/ajouter/' . $produitId);
        $client->request('GET', '/commande/adresse');
        $this->assertResponseIsSuccessful();
        $this->assertSelectorExists('form');
    }

    public function testAdressePostValideRedirigeVersCommande(): void
    {
        [$client, $produitId] = $this->clientConnecte();
        $client->request('POST', '/panier/ajouter/' . $produitId);

        $crawler   = $client->request('GET', '/commande/adresse');
        $csrfToken = $crawler->filter('input[name="_token"]')->attr('value');

        $client->request('POST', '/commande/adresse', [
            'firstName'  => 'Jean',
            'lastName'   => 'Dupont',
            'address1'   => '12 rue de la Paix',
            'postalCode' => '75001',
            'city'       => 'Paris',
            'country'    => 'FR',
            'phone'      => '',
            'notes'      => '',
            '_token'     => $csrfToken,
        ]);
        $this->assertResponseRedirects('/commande');
    }

    public function testAdressePostChampsManquantsAfficheErreurs(): void
    {
        [$client, $produitId] = $this->clientConnecte();
        $client->request('POST', '/panier/ajouter/' . $produitId);

        $crawler   = $client->request('GET', '/commande/adresse');
        $csrfToken = $crawler->filter('input[name="_token"]')->attr('value');

        $client->request('POST', '/commande/adresse', [
            'firstName'  => '',
            'lastName'   => '',
            'address1'   => '',
            'postalCode' => '',
            'city'       => '',
            '_token'     => $csrfToken,
        ]);
        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('body', 'obligatoire');
    }

    public function testCommandeSansAdresseEnSessionRedirigeVersAdresse(): void
    {
        [$client, $produitId] = $this->clientConnecte();
        $client->request('POST', '/panier/ajouter/' . $produitId);
        $client->request('GET', '/commande');
        $this->assertResponseRedirects('/commande/adresse');
    }

    public function testCommandeAvecAdresseEnSession(): void
    {
        [$client, $produitId] = $this->clientConnecte();
        $client->request('POST', '/panier/ajouter/' . $produitId);

        $crawler   = $client->request('GET', '/commande/adresse');
        $csrfToken = $crawler->filter('input[name="_token"]')->attr('value');

        $client->request('POST', '/commande/adresse', [
            'firstName'  => 'Jean',
            'lastName'   => 'Dupont',
            'address1'   => '12 rue de la Paix',
            'postalCode' => '75001',
            'city'       => 'Paris',
            'country'    => 'FR',
            'phone'      => '',
            'notes'      => '',
            '_token'     => $csrfToken,
        ]);

        $client->request('GET', '/commande');
        $this->assertResponseIsSuccessful();
    }
}
