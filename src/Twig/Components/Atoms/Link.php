<?php

namespace App\Twig\Components\Atoms;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent]
final class Link
{
    public bool $external = false;
    public bool $current = false;  // ajoute aria-current="page" si true
    public string $variant = '';   // cta | outline
}
