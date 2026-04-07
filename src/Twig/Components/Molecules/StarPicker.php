<?php

namespace App\Twig\Components\Molecules;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent]
final class StarPicker
{
    public string $name = 'note';
    public int $value = 0;
    public string $label = 'Note';
    public bool $required = false;
    public int $max = 5;
}
