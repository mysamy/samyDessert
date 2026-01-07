<?php

namespace App\Twig\Components\Molecules;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent]
final class SelectField
{
    public string $id = '';
    public string $name = '';
    public string $label = '';

    public ?string $value = null;

    public bool $required = false;
    public bool $disabled = false;
    public bool $multiple = false;

    public bool $invalid = false;
    public ?string $error = null;
    public ?string $help = null;

    public ?string $ariaLabel = null;

    public ?string $placeholder = null;

    public string $class = '';
    public string $selectClass = '';

    public array $options = [];

    public function getComputedId(): string
    {
        if ($this->id !== '') {
            return $this->id;
        }

        if ($this->name !== '') {
            $id = preg_replace('/[^a-zA-Z0-9\-_:.]+/', '_', $this->name);
            return $id ?: 'select';
        }

        return 'select';
    }

    public function getHelpId(): string
    {
        return $this->getComputedId().'__help';
    }

    public function getErrorId(): string
    {
        return $this->getComputedId().'__error';
    }

    public function getDescribedBy(): ?string
    {
        $ids = [];

        if ($this->help) {
            $ids[] = $this->getHelpId();
        }

        if ($this->error) {
            $ids[] = $this->getErrorId();
        }

        return $ids ? implode(' ', $ids) : null;
    }

    public function getEffectiveInvalid(): bool
    {
        return $this->invalid || (bool) $this->error;
    }

    public function getEffectiveAriaLabel(): ?string
    {
        if ($this->label !== '') {
            return null;
        }

        return $this->ariaLabel;
    }

    public function isSelected(?string $candidate): bool
    {
        if ($candidate === null) {
            return $this->value === null || $this->value === '';
        }

        return (string) $this->value === (string) $candidate;
    }
}
