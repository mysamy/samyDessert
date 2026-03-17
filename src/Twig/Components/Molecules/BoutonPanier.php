<?php

namespace App\Twig\Components\Molecules;

use App\Service\PanierService;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\Attribute\LiveAction;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\ComponentToolsTrait;
use Symfony\UX\LiveComponent\DefaultActionTrait;

// Live component : bouton "Ajouter au panier" sur une carte produit.
// Quand on clique, le panier se met à jour sans rechargement de page.
#[AsLiveComponent]
final class BoutonPanier
{
    use DefaultActionTrait;
    use ComponentToolsTrait;

    #[LiveProp]
    public int $produitId = 0;

    #[LiveProp]
    public string $produitNom = '';

    public function __construct(private PanierService $panier) {}

    // Toujours lu depuis la session — fiable sur page reload et live re-render
    public function getQuantite(): int
    {
        return $this->panier->getQuantitePourProduit($this->produitId);
    }

    #[LiveAction]
    public function ajouter(): void
    {
        $this->panier->ajouter($this->produitId);
        $this->emit('panierUpdated');
    }

    #[LiveAction]
    public function retirer(): void
    {
        $this->panier->retirer($this->produitId);
        $this->emit('panierUpdated');
    }
}
