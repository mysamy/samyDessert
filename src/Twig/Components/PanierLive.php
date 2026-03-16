<?php

namespace App\Twig\Components;

use App\Service\PanierService;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\Attribute\LiveAction;
use Symfony\UX\LiveComponent\Attribute\LiveArg;
use Symfony\UX\LiveComponent\DefaultActionTrait;

// Live component : affichage complet du panier avec mise à jour en temps réel.
// Les boutons +/−/supprimer/vider ne rechargent pas la page.
#[AsLiveComponent]
final class PanierLive
{
    use DefaultActionTrait;

    public function __construct(private PanierService $panier) {}

    // Lignes du panier enrichies : [['produit' => Produit, 'quantite' => int], ...]
    public function getLignes(): array
    {
        return $this->panier->getLignes();
    }

    public function getTotal(): float
    {
        return $this->panier->getTotal();
    }

    public function getNombreArticles(): int
    {
        return $this->panier->getNombreArticles();
    }

    #[LiveAction]
    public function ajouter(#[LiveArg] int $id): void
    {
        $this->panier->ajouter($id);
    }

    #[LiveAction]
    public function retirer(#[LiveArg] int $id): void
    {
        $this->panier->retirer($id);
    }

    #[LiveAction]
    public function supprimer(#[LiveArg] int $id): void
    {
        $this->panier->supprimer($id);
    }

    #[LiveAction]
    public function vider(): void
    {
        $this->panier->vider();
    }
}
