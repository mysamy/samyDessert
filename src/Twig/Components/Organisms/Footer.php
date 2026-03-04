<?php

namespace App\Twig\Components\Organisms;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent]
final class Footer
{
    public ?string $id = null;
    public ?string $class = null;

    public string $brandLabel = '';
    public array $links = [];

    public ?string $legalText = null;
}
