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

    // IDs des produits en favoris (pour afficher le coeur rempli)
    public array $favorisIds = [];

    // Map productId => noteMoyenne (optionnel)
    public array $ratingsMap = [];

    public function getTitleId(): string
    {
        $base = $this->id ?: 'product-card-grid';
        return $base . '-title';
    }
}
