<?php

namespace App\Twig\Components\Molecules;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent]
final class ProductCard
{
    public string $title;
    public float $price;
    public string $image;
    public int $rating = 0; // 0 à 5
    public string $addToCartUrl;
}
