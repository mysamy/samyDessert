<?php

namespace App\Twig\Components\Atoms;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent('Atoms:Badge')]
final class Badge
{
    public string $variant = 'default';
}
