<?php

namespace App\Twig\Components\Molecules;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent]
final class FormFieldGroup
{
    public string $id = '';
    public string $legend = '';
    public ?string $description = null;

    public string $class = '';
    public string $innerClass = 'space-y-4';

    public function getComputedId(): string
    {
        return $this->id !== '' ? $this->id : 'form-field-group';
    }

    public function getLegendId(): string
    {
        return $this->getComputedId().'__legend';
    }

    public function getDescriptionId(): string
    {
        return $this->getComputedId().'__description';
    }

    public function getAriaDescribedBy(): ?string
    {
        if (!$this->description) {
            return null;
        }

        return $this->getDescriptionId();
    }

    public function hasLegend(): bool
    {
        return $this->legend !== '';
    }
}
