<?php

namespace App\Twig\Components\Organisms;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent]
final class Form
{
    public string $method = 'post';
    public ?string $action = null;
    public string $id = '';

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
}
