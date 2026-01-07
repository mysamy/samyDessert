<?php

namespace App\Twig\Components\Atoms;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent('Atoms:Checkbox')]
final class Checkbox
{
    public bool $checked = false;
    public bool $disabled = false;
}
