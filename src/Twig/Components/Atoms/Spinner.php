<?php

namespace App\Twig\Components\Atoms;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent('Atoms:Spinner')]
final class Spinner
{
    public string $size = 'md';
}
