<?php

namespace App\Twig\Components\Molecules;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent]
final class CookieBanner
{
    public string $message = 'Ce site utilise des cookies pour améliorer votre expérience.';
    public string $acceptLabel = 'Accepter';
    public string $rejectLabel = 'Refuser';
    public string $policyUrl = '';
}