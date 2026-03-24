<?php

namespace App\Twig\Components\Molecules;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent]
final class FlashTooltip
{
    public string $message = '';
    public int $duration = 3000;
}