<?php

namespace App\Twig\Components\Atoms;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent]
final class Select
{
    public bool $disabled = false;
    public bool $multiple = false;
    public bool $required = false;
}
