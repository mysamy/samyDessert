<?php

namespace App\Twig\Components\Atoms;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent('Atoms:Textarea')]
final class Textarea
{
    public bool $disabled = false;
    public int $rows = 4;
}
