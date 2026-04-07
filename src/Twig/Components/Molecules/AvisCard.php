<?php

namespace App\Twig\Components\Molecules;

use App\Entity\Avis;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent]
final class AvisCard
{
    public Avis $avis;
}
