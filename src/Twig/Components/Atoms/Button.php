<?php

namespace App\Twig\Component\Atoms;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent]
final class Button
{

    public string $label = 'Bouton';
    public string $type = 'button'; 
    public string $variant = 'primary'; 
    public string $size = 'md'; 
    public bool $disabled = false;
}
