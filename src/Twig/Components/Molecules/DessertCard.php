<?php

namespace App\Twig\Components\Molecules;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

// Composant carte dessert — affiche une recette en mode liste/grille
#[AsTwigComponent]
final class DessertCard
{
    public string $titre = '';
    public ?string $description = null;
    public ?string $imageSrc = null;
    public string $difficulte = '';
    public ?string $temps = null;
    public ?int $portions = null;
    public ?string $categorieLabel = null;
    public ?string $url = null;

    // Classe CSS du badge difficulté selon le niveau
    public function getDifficulteClass(): string
    {
        return match ($this->difficulte) {
            'Facile' => 'bg-green-100 text-green-700',
            'Moyen'  => 'bg-amber-100 text-amber-700',
            default  => 'bg-red-100 text-red-700',
        };
    }
}
