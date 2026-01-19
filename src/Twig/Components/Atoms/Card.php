<?php

namespace App\Twig\Components\Atoms;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent]
final class Card
{
    public string $id = '';
    public string $class = '';

    public ?string $title = null;
    public string $titleTag = 'h3';

    public function getTitleId(): string
    {
        $base = $this->id !== '' ? $this->id : 'card';
        return $base.'__title';
    }

    public function getSafeTitleTag(): string
    {
        return in_array($this->titleTag, ['h2', 'h3', 'h4'], true) ? $this->titleTag : 'h3';
    }
}
