<?php

namespace App\Tests\Entity;

use App\Entity\Commande;
use App\Entity\Utilisateur;
use App\Enum\StatutCommande;
use PHPUnit\Framework\TestCase;

class CommandeTest extends TestCase
{
    public function testConstructeurInitialiseDateEtStatut(): void
    {
        $commande = new Commande();

        $this->assertInstanceOf(\DateTimeInterface::class, $commande->getDateCommande());
        $this->assertSame(StatutCommande::EnAttente, $commande->getStatut());
    }

    public function testDateCommandeEstAujourdhui(): void
    {
        $avant    = new \DateTime();
        $commande = new Commande();
        $apres    = new \DateTime();

        $this->assertGreaterThanOrEqual($avant->getTimestamp(), $commande->getDateCommande()->getTimestamp());
        $this->assertLessThanOrEqual($apres->getTimestamp(), $commande->getDateCommande()->getTimestamp());
    }

    public function testSetterGetterTotal(): void
    {
        $commande = new Commande();
        $commande->setTotal('49.90');

        $this->assertSame('49.90', $commande->getTotal());
    }

    public function testSetterGetterStatut(): void
    {
        $commande = new Commande();
        $commande->setStatut(StatutCommande::Confirmee);

        $this->assertSame(StatutCommande::Confirmee, $commande->getStatut());
    }

    public function testSetterGetterReference(): void
    {
        $commande = new Commande();
        $commande->setReference('CMD-2026-00042');

        $this->assertSame('CMD-2026-00042', $commande->getReference());
    }

    public function testSetterGetterAdresseLivraison(): void
    {
        $commande = new Commande();
        $commande->setAdresseLivraison('12 rue de la Paix');
        $commande->setVille('Paris');
        $commande->setCodePostal('75001');

        $this->assertSame('12 rue de la Paix', $commande->getAdresseLivraison());
        $this->assertSame('Paris', $commande->getVille());
        $this->assertSame('75001', $commande->getCodePostal());
    }

    public function testSetterGetterUtilisateur(): void
    {
        $commande    = new Commande();
        $utilisateur = new Utilisateur();
        $utilisateur->setEmail('test@test.com');

        $commande->setUtilisateur($utilisateur);

        $this->assertSame($utilisateur, $commande->getUtilisateur());
    }

    public function testStatutEnumValeurs(): void
    {
        $this->assertSame('en_attente', StatutCommande::EnAttente->value);
        $this->assertSame('confirmee',  StatutCommande::Confirmee->value);
        $this->assertSame('livree',     StatutCommande::Livree->value);
        $this->assertSame('annulee',    StatutCommande::Annulee->value);
    }

    public function testCommandeProduitsVideALaCreation(): void
    {
        $commande = new Commande();
        $this->assertCount(0, $commande->getCommandeProduits());
    }
}
