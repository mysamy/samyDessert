<?php

namespace App\Twig\Components\Molecules;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent]
class CarouselCard
{
    public int $number = 1;
    public string $imgSrc = '';
    public string $imgAlt = '';
    public string $imgClass = '';
    public string $description = '';
}
