<?php

namespace App\Twig\Components\Organisms;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent]
final class Footer
{
    public string $brandLabel = '';
    public string $tagline = '';
    public array $links = [];
    public array $legalLinks = [];
    public array $socialLinks = [];

    public ?string $legalText = null;
}
