<?php

namespace App\Twig\Components\Atoms;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent]
final class ButtonIcon
{
    public string $name = '';
    public string $type = 'button';
    public string $variant = 'outline'; // outline | filled
    public string $size = 'md';        // sm | md | lg
    public bool $disabled = false;
}
