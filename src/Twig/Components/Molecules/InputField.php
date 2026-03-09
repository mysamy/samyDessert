<?php

namespace App\Twig\Components\Molecules;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent]
final class InputField
{
    public string $type = 'text';
    public string $id = '';
    public string $name = '';
    public string $label = '';
    public string $placeholder = '';
    public string $value = '';

    public bool $required = false;
    public bool $disabled = false;
    public bool $readonly = false;

    public bool $invalid = false;
    public string $error = '';
    public string $help = '';

    public string $ariaLabel = '';

    public string $autocomplete = '';
    public string $inputmode = '';
    public ?int $maxlength = null;
    public ?string $pattern = null;

    public string $class = '';

    public function getComputedId(): string
    {
        if ($this->id !== '') {
            return $this->id;
        }

        if ($this->name !== '') {
            $id = preg_replace('/[^a-zA-Z0-9\-_:.]+/', '_', $this->name);
            return $id ?: 'input';
        }

        return 'input';
    }

    public function getHelpId(): string
    {
        return $this->getComputedId().'__help';
    }

    public function getErrorId(): string
    {
        return $this->getComputedId().'__error';
    }

    public function getDescribedBy(): string
    {
        $ids = [];

        if ($this->help !== '') {
            $ids[] = $this->getHelpId();
        }

        if ($this->error !== '') {
            $ids[] = $this->getErrorId();
        }

        return $ids ? implode(' ', $ids) : '';
    }

    public function getEffectiveInvalid(): bool
    {
        return $this->invalid || ($this->error !== '');
    }

    public function getEffectiveAriaLabel(): string
    {
        if ($this->label !== '') {
            return '';
        }

        return $this->ariaLabel;
    }
}
