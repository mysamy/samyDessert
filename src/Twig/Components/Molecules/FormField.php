<?php

namespace App\Twig\Components\Molecules;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent]
final class FormField
{
    public string $label = '';
    public ?string $error = null;
    public ?string $id = null;
    public bool $required = false;

    public function getComputedId(): string
    {
        return $this->id ?? 'field-' . bin2hex(random_bytes(4));
    }

    public function getErrorId(): string
    {
        return $this->getComputedId() . '__error';
    }
}
