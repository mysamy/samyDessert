<?php

namespace App\Twig\Components\Organisms;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent]
final class ProductCardGrid
{
    public ?string $id = null;
    public ?string $class = null;

    public ?string $title = null;

    public array $items = [];

    public string $type = 'produit'; // 'produit' ou 'recette'

    // IDs des favoris (pour afficher le coeur rempli)
    public array $favorisIds = [];

    // Map id => noteMoyenne (optionnel, produits uniquement)
    public array $ratingsMap = [];

    public function getTitleId(): string
    {
        $base = $this->id ?: 'product-card-grid';
        return $base . '-title';
    }
}
