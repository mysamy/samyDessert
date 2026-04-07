<?php

namespace App\Twig\Components\Organisms;

use App\Entity\Avis;
use App\Entity\Produit;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent]
final class AvisSection
{
    public Produit $produit;
    public ?float $noteMoyenne = null;
    public ?Avis $monAvis = null;

    private array $avisItems = [];

    public function mount(Produit $produit, array $avis = [], ?float $noteMoyenne = null, ?Avis $monAvis = null): void
    {
        $this->produit = $produit;
        $this->avisItems = $avis;
        $this->noteMoyenne = $noteMoyenne;
        $this->monAvis = $monAvis;
    }

    public function getAvis(): array
    {
        return $this->avisItems;
    }
}
