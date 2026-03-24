<?php

namespace App\Twig\Components\Molecules;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;
use Symfony\Component\HttpFoundation\RequestStack;

#[AsTwigComponent]
final class NavigationLinks
{
    public array $links = [];

    public function __construct(
        private readonly RequestStack $requestStack,
    ) {
    }

    public function mount(): void
    {
        $request = $this->requestStack->getCurrentRequest();
        $path = $request?->getPathInfo() ?? '/';

        $this->links = [
            ['label' => 'Accueil', 'href' => '/', 'current' => $path === '/'],
            ['label' => 'Desserts et prix', 'href' => '/produits', 'current' => str_starts_with($path, '/produits')],
            ['label' => 'Recettes', 'href' => '/recettes', 'current' => str_starts_with($path, '/recettes')],
            ['label' => 'Contactez-moi', 'href' => '/contact', 'current' => $path === '/contact'],
        ];
    }
}
