<?php

namespace App\Twig\Components\Atoms;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent('Atoms:Select')]
final class Select
{
    public bool $disabled = false;
}
