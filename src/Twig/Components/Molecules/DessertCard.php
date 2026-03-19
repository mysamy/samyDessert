<?php

namespace App\Twig\Components\Molecules;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

// Composant carte universelle — recette (url + "Voir la recette") ou produit (prix + "Ajouter au panier")
#[AsTwigComponent]
final class DessertCard
{
    public string $titre = '';
    public ?string $description = null;
    public ?string $imageSrc = null;
    public ?string $url = null;

    // Props recette
    public string $difficulte = '';
    public ?string $temps = null;
    public ?int $portions = null;
    public ?string $categorieLabel = null;

    // Props produit
    public ?string $prix = null;
    public ?float $rating = null;
    public ?int $produitId = null;     // ID pour le live component BoutonPanier
    public ?string $addToCartUrl = null; // conservé pour rétrocompatibilité (ignoré si produitId est défini)
    public string $addToCartLabel = 'Ajouter au panier';
    public bool $addToCartDisabled = false;
}