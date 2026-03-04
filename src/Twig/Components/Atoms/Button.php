<?php

namespace App\Twig\Components\Atoms;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent]
final class Button
{
    public string $type = 'button';
    public bool $disabled = false;
    public string $size = 'md';
    public string $variant = 'primary';
}
