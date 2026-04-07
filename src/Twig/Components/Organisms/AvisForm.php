<?php

namespace App\Twig\Components\Organisms;

use App\Entity\Avis;
use App\Entity\Produit;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent]
final class AvisForm
{
    public Produit $produit;
    public ?Avis $monAvis = null;
}
