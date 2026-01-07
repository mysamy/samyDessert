<?php

namespace App\Twig\Components\Atoms;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent('Atoms:Input')]
final class Input
{
    public string $type = 'text';
    public ?string $value = null;
    public bool $disabled = false;
}
