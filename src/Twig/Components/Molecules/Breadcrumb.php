<?php

namespace App\Twig\Components\Molecules;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent]
final class Breadcrumb
{
    public string $parentLabel = '';
    public string $parentHref = '';
    public string $currentLabel = '';
}
