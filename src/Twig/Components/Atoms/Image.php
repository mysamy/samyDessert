<?php

namespace App\Twig\Components\Atoms;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent]
final class Image
{
    public string $src = '';
    public string $alt = '';
    public string $class = '';
    public string $loading = 'lazy';
}
