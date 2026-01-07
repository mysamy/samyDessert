<?php

namespace App\Twig\Components\Molecules;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent]
final class CheckboxField
{
    public string $id;
    public string $label;
    public bool $checked = false;
    public bool $required = false;
    public ?string $error = null;
}
