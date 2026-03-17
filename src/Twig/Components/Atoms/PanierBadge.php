<?php

namespace App\Twig\Components\Atoms;

use App\Service\PanierService;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\Attribute\LiveListener;
use Symfony\UX\LiveComponent\DefaultActionTrait;

#[AsLiveComponent]
final class PanierBadge
{
    use DefaultActionTrait;

    public function __construct(private PanierService $panier) {}

    public function getNombreArticles(): int
    {
        return $this->panier->getNombreArticles();
    }

    #[LiveListener('panierUpdated')]
    public function onPanierUpdated(): void {}
}
