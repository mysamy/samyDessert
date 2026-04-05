<?php

namespace App\Twig\Components\Molecules;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent]
final class SearchBar
{
    public string $action = '';
    public string $value = '';
    public string $placeholder = 'Rechercher...';
    public string $buttonLabel = 'Rechercher';
    public string $name = 'q';
    public string $frameId = '';
}
