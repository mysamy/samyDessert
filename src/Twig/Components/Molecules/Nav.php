<?php

namespace App\Twig\Components\Molecules;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent]
final class Nav
{
    public array $links = [];
    public string $ariaLabel = 'Navigation principale';
   
}
