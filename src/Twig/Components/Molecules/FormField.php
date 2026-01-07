<?php

namespace App\Twig\Components\Molecules;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent]
final class FormField
{
    public string $label;
    public ?string $error = null;
    public ?string $id = null;
    public bool $required = false;
}
