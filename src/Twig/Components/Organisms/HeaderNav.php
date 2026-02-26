<?php

namespace App\Twig\Components\Organisms;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent]
final class HeaderNav
{
    public string $brandLabel = '';
    public string $brandHref = '/';

    public string $logoSrc = '';
    public string $logoAlt = '';

    public array $links = [];

    public string $class = '';
}
