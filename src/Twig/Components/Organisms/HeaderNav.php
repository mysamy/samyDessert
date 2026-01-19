<?php

namespace App\Twig\Components\Organisms;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent]
final class HeaderNav
{
    public ?string $id = null;
    public ?string $class = null;

    public string $brandLabel = 'Accueil';
    public string $brandUrl = '#';

    public array $links = [];

    public ?string $accountUrl = null;
    public ?string $cartUrl = null;
}
