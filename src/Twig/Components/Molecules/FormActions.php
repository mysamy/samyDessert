<?php

namespace App\Twig\Components\Molecules;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent]
final class FormActions
{
    public string $align = 'end';
    public bool $disabled = false;

    public function getAlignmentClass(): string
    {
        return match ($this->align) {
            'start'   => 'justify-start',
            'center'  => 'justify-center',
            'between' => 'justify-between',
            default   => 'justify-end',
        };
    }
}
