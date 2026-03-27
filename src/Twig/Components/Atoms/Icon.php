<?php

namespace App\Twig\Components\Atoms;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent]
final class Icon
{
    public string $name = '';
    public string $variant = 'solid';
    public string $size = '';
    public bool $decorative = true;
    public string $ariaLabel = '';
}
