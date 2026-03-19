<?php

namespace App\Twig\Components\Atoms;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent]
final class Checkbox
{
    public bool $checked = false;
    public bool $disabled = false;
    public bool $required = false;
}
