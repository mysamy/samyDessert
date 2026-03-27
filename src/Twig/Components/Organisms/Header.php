<?php

namespace App\Twig\Components\Organisms;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent]
final class Header
{
    public string $brandLabel = '';
    public string $brandHref = '/';
    public ?string $logoSrc = null;
    public ?string $logoAlt = null;
}