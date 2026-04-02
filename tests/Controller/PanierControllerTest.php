<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class PanierControllerTest extends WebTestCase
{
    public function testAjouterAuPanierRedirigue(): void
    {
        $client = static::createClient();
        // PanierService ajoute l'ID en session sans vérifier l'existence du produit
        $client->request('POST', '/panier/ajouter/1');
        $this->assertResponseRedirects('/panier');
    }

    public function testRetirerDuPanierRedirigue(): void
    {
        $client = static::createClient();
        $client->request('POST', '/panier/ajouter/1');
        $client->request('POST', '/panier/retirer/1');
        $this->assertResponseRedirects('/panier');
    }

    public function testSupprimerDuPanierRedirigue(): void
    {
        $client = static::createClient();
        $client->request('POST', '/panier/ajouter/1');
        $client->request('POST', '/panier/supprimer/1');
        $this->assertResponseRedirects('/panier');
    }

    public function testViderPanierRedirigue(): void
    {
        $client = static::createClient();
        $client->request('POST', '/panier/vider');
        $this->assertResponseRedirects('/panier');
    }

    public function testPanierVide(): void
    {
        $client = static::createClient();
        $client->request('GET', '/panier');
        $this->assertResponseIsSuccessful();
    }

    public function testPanierApresPlusieursActions(): void
    {
        $client = static::createClient();
        $client->request('POST', '/panier/ajouter/5');
        $client->request('POST', '/panier/ajouter/5');
        $client->request('POST', '/panier/retirer/5');
        $client->request('POST', '/panier/vider');

        $client->request('GET', '/panier');
        $this->assertResponseIsSuccessful();
    }
}
