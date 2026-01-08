<?php

namespace App\Twig\Components\Molecules;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent]
final class RadioGroup
{
    public string $id = '';
    public string $name = '';

    public string $legend = '';
    public ?string $description = null;

    public ?string $value = null;

    public bool $required = false;
    public bool $disabled = false;

    public bool $invalid = false;
    public ?string $error = null;

    public string $class = '';
    public string $innerClass = 'space-y-2';

    public array $options = [];

    public function getComputedId(): string
    {
        if ($this->id !== '') {
            return $this->id;
        }

        if ($this->name !== '') {
            $id = preg_replace('/[^a-zA-Z0-9\-_:.]+/', '_', $this->name);
            return $id ?: 'radio-group';
        }

        return 'radio-group';
    }

    public function getLegendId(): string
    {
        return $this->getComputedId().'__legend';
    }

    public function getDescriptionId(): string
    {
        return $this->getComputedId().'__description';
    }

    public function getErrorId(): string
    {
        return $this->getComputedId().'__error';
    }

    public function getDescribedBy(): string
    {
        $ids = [];

        if ($this->description) {
            $ids[] = $this->getDescriptionId();
        }

        if ($this->error) {
            $ids[] = $this->getErrorId();
        }

        return implode(' ', $ids);
    }

    public function getEffectiveInvalid(): bool
    {
        return $this->invalid || (bool) $this->error;
    }

    public function isChecked(?string $candidate): bool
    {
        if ($candidate === null) {
            return $this->value === null || $this->value === '';
        }

        return (string) $this->value === (string) $candidate;
    }

    public function getOptionId(string $value): string
    {
        $v = preg_replace('/[^a-zA-Z0-9\-_:.]+/', '_', $value);
        return $this->getComputedId().'__'.$v;
    }
}
