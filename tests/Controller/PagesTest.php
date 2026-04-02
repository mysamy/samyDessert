<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * Vérifie que les pages principales répondent correctement.
 * Pas de base de données — utilise le client HTTP interne de Symfony.
 */
class PagesTest extends WebTestCase
{
    // Pages accessibles sans être connecté
    public function testPageAccueil(): void
    {
        $client = static::createClient();
        $client->request('GET', '/');
        $this->assertResponseIsSuccessful();
    }

    public function testPageProduits(): void
    {
        $client = static::createClient();
        $client->request('GET', '/produits');
        $this->assertResponseIsSuccessful();
    }

    public function testPageRecettes(): void
    {
        $client = static::createClient();
        $client->request('GET', '/recettes');
        $this->assertResponseIsSuccessful();
    }

    public function testPageContact(): void
    {
        $client = static::createClient();
        $client->request('GET', '/contact');
        $this->assertResponseIsSuccessful();
    }

    public function testPageConnexion(): void
    {
        $client = static::createClient();
        $client->request('GET', '/connexion');
        $this->assertResponseIsSuccessful();
    }

    public function testPageInscription(): void
    {
        $client = static::createClient();
        $client->request('GET', '/inscription');
        $this->assertResponseIsSuccessful();
    }

    public function testPagePanier(): void
    {
        $client = static::createClient();
        $client->request('GET', '/panier');
        $this->assertResponseIsSuccessful();
    }

    // Pages protégées — doivent rediriger vers /connexion si non connecté
    public function testCommandeAdresseExigeConnexion(): void
    {
        $client = static::createClient();
        $client->request('GET', '/commande/adresse');
        $this->assertResponseRedirects('/connexion');
    }

    public function testCommandeExigeConnexion(): void
    {
        $client = static::createClient();
        $client->request('GET', '/commande');
        $this->assertResponseRedirects('/connexion');
    }

    public function testMonCompteExigeConnexion(): void
    {
        $client = static::createClient();
        $client->request('GET', '/mon-compte');
        $this->assertResponseRedirects('/connexion');
    }

    // Page introuvable
    public function testPageInexistanteRetourne404(): void
    {
        $client = static::createClient();
        $client->request('GET', '/cette-page-nexiste-pas');
        $this->assertResponseStatusCodeSame(404);
    }
}
