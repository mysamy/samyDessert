<?php

namespace App\Twig\Components\Atoms;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent]
final class Spinner
{
    public string $size = 'md';
    public string $ariaLabel = 'Chargement';
}
