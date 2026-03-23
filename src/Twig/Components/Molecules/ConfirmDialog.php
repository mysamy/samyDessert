<?php

namespace App\Twig\Components\Molecules;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent]
class ConfirmDialog
{
    public string $id = 'confirm-dialog';
    public string $title = 'Confirmation';
    public string $message = '';
    public string $confirmLabel = 'Confirmer';
    public string $cancelLabel = 'Annuler';
    public string $confirmVariant = 'danger'; // danger | primary | success
}
