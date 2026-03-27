<?php

namespace App\Twig\Extension;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class PrixExtension extends AbstractExtension
{
    public function getFilters(): array
    {
        return [
            new TwigFilter('prix', [$this, 'formatPrix']),
        ];
    }

    public function formatPrix(float|int|string|null $montant): string
    {
        if ($montant === null) {
            return '0,00 €';
        }

        return number_format((float) $montant, 2, ',', ' ') . ' €';
    }
}