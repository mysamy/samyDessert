<?php

namespace App\Twig\Components\Organisms;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent]
final class Form
{
    public string $method = 'post';
    public ?string $action = null;
    public string $id = '';
    public string $class = '';

    public bool $novalidate = false;
    public bool $disabled = false;

    public ?string $ariaLabel = null;
    public ?string $ariaDescribedby = null;

    public function getComputedId(): ?string
    {
        return $this->id !== '' ? $this->id : null;
    }

    public function getEffectiveMethod(): string
    {
        $m = strtolower(trim($this->method));
        return in_array($m, ['get', 'post'], true) ? $m : 'post';
    }

    public function getEffectiveAction(): ?string
    {
        return $this->action !== '' ? $this->action : null;
    }

    public function getEffectiveAriaLabel(): ?string
    {
        return $this->ariaLabel !== '' ? $this->ariaLabel : null;
    }

    public function getEffectiveAriaDescribedby(): ?string
    {
        return $this->ariaDescribedby !== '' ? $this->ariaDescribedby : null;
    }
}
