<?php

namespace App\Twig\Components\Atoms;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent]
final class Text
{
    public string $text = '';
    public ?string $id = null;
    public string $as = 'p';
    public string $class = '';
    public ?string $role = null;
}
