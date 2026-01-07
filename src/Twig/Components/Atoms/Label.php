<?php

namespace App\Twig\Components\Atoms;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent]
final class Label
{
    public string $label = '';
    public ?string $forId = null;
    public string $class = '';
}
