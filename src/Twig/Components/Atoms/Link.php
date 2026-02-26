<?php

namespace App\Twig\Components\Atoms;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent]
final class Link
{
    public string $href = '';
    public bool $external = false;
    public string $ariaLabel = '';
  
}
