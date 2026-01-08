<?php

namespace App\Twig\Components\Molecules;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent]
final class TextareaField
{
    public string $id = '';
    public string $name = '';
    public string $label = '';

    public ?string $value = null;
    public ?string $placeholder = null;

    public bool $required = false;
    public bool $disabled = false;
    public bool $readonly = false;

    public bool $invalid = false;
    public ?string $error = null;
    public ?string $help = null;

    public ?string $ariaLabel = null;

    public int $rows = 4;
    public ?int $maxlength = null;

    public string $class = '';
    public string $textareaClass = '';

    public string $ariaInvalid = 'false';
    public string $describedBy = '';
    public string $computedId = '';

    public function mount(): void
    {
        $this->computedId = $this->computeId();
        $this->describedBy = $this->computeDescribedBy();
        $this->ariaInvalid = ($this->invalid || (bool) $this->error) ? 'true' : 'false';
    }

    private function computeId(): string
    {
        if ($this->id !== '') {
            return $this->id;
        }

        if ($this->name !== '') {
            $id = preg_replace('/[^a-zA-Z0-9\-_:.]+/', '_', $this->name);
            return $id ?: 'textarea';
        }

        return 'textarea';
    }

    private function computeDescribedBy(): string
    {
        $ids = [];

        if ($this->help) {
            $ids[] = $this->computedId.'__help';
        }

        if ($this->error) {
            $ids[] = $this->computedId.'__error';
        }

        return implode(' ', $ids);
    }

    public function getHelpId(): string
    {
        return $this->computedId.'__help';
    }

    public function getErrorId(): string
    {
        return $this->computedId.'__error';
    }

    public function getEffectiveAriaLabel(): string
    {
        if ($this->label !== '') {
            return '';
        }

        return (string) ($this->ariaLabel ?? '');
    }
}
