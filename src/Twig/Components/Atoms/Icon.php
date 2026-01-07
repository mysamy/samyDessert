<?php

namespace App\Twig\Components\Atoms;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent]
class Icon
{
    public string $name;
    public string $style = 'solid';
    public ?string $size = null;
    public bool $decorative = true;
    public ?string $ariaLabel = null;
    

}
