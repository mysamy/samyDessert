<?php

namespace App\Twig\Components\Atoms;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent('Atoms:Button')]
final class Button
{
    public string $type = 'button';
    public string $variant = 'primary';
    public string $size = 'md';
    public bool $disabled = false;
}
