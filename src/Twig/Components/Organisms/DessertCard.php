<?php

namespace App\Twig\Components\Organisms;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

// Composant carte universelle — recette (url + "Voir la recette") ou produit (prix + "Ajouter au panier")
#[AsTwigComponent]
final class DessertCard
{
    public string $titre = '';
    public ?string $description = null;
    public ?string $imageSrc = null;
    public ?string $url = null;

    // Favori
    public bool $favori = false;          // déjà en favori ?
    public ?string $favoriUrl = null;     // URL pour toggle (null = pas de bouton)

    // Props recette
    public string $difficulte = '';
    public ?string $temps = null;
    public ?int $portions = null;
    public ?string $categorieLabel = null;

    // Props produit
    public ?string $prix = null;
    public ?float $rating = null;
    public ?int $produitId = null;     // ID pour le live component BoutonPanier
}