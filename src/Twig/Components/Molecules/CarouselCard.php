<?php

namespace App\Twig\Components\Molecules;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent]
final class CarouselCard
{
    public string $imgSrc = '';
    public string $imgAlt = '';
    public string $imgClass = '';
    public string $description = '';
}
