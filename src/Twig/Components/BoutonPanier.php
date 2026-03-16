<?php

namespace App\Twig\Components;

use App\Service\PanierService;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\Attribute\LiveAction;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\DefaultActionTrait;

// Live component : bouton "Ajouter au panier" sur une carte produit.
// Quand on clique, le panier se met à jour sans rechargement de page.
#[AsLiveComponent]
final class BoutonPanier
{
    use DefaultActionTrait;

    // ID du produit à ajouter (passé depuis le template appelant)
    #[LiveProp]
    public int $produitId = 0;

    // Nom du produit (pour l'aria-label)
    #[LiveProp]
    public string $produitNom = '';

    // Quantité actuelle de ce produit dans le panier
    #[LiveProp]
    public int $quantite = 0;

    public function __construct(private PanierService $panier) {}

    // Initialise la quantité depuis la session au premier rendu (lecture session, pas de SQL)
    public function mount(): void
    {
        $this->quantite = $this->panier->getQuantitePourProduit($this->produitId);
    }

    #[LiveAction]
    public function ajouter(): void
    {
        $this->panier->ajouter($this->produitId);
        $this->quantite = $this->panier->getQuantitePourProduit($this->produitId);
    }

    #[LiveAction]
    public function retirer(): void
    {
        $this->panier->retirer($this->produitId);
        $this->quantite = $this->panier->getQuantitePourProduit($this->produitId);
    }
}