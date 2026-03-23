<?php

namespace App\Twig\Components\Atoms;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent]
final class Textarea
{
    public string $value = '';
    public int $rows = 4;
    public bool $disabled = false;
    public bool $required = false;
    public bool $readonly = false;
}
