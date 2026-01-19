<?php

namespace App\Twig\Components\Molecules;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent]
final class Nav
{
    public ?string $id = null;
    public ?string $class = null;

    public string $ariaLabel = 'Navigation';
    public array $items = [];
}
