<?php

namespace App\Twig\Components\Organisms;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Vich\UploaderBundle\Storage\StorageInterface;

#[AsTwigComponent]
final class ProductCardGrid
{
    public ?string $id = null;
    public ?string $class = null;
    public ?string $title = null;
    public string $type = 'produit'; // 'produit' ou 'recette'
    public array $favorisIds = [];
    public array $ratingsMap = [];

    private array $rawItems = [];
    private array $normalizedItems = [];

    public function __construct(
        private UrlGeneratorInterface $router,
        private StorageInterface $storage,
    ) {}

    public function mount(
        array $items = [],
        string $type = 'produit',
        array $favorisIds = [],
        array $ratingsMap = [],
    ): void {
        $this->rawItems = $items;
        $this->type = $type;
        $this->favorisIds = $favorisIds;
        $this->ratingsMap = $ratingsMap;

        $route = $type === 'recette' ? 'app_recette_show' : 'app_produit_show';

        $this->normalizedItems = array_map(function ($item) use ($type, $route) {
            $id = $item->getId();
            $slug = method_exists($item, 'getSlug') ? $item->getSlug() : null;
            $imageName = method_exists($item, 'getImageName') ? $item->getImageName() : null;

            return [
                'titre'          => method_exists($item, 'getNom') ? $item->getNom() : (method_exists($item, 'getTitre') ? $item->getTitre() : ''),
                'description'    => method_exists($item, 'getDescription') ? $item->getDescription() : null,
                'url'            => $slug ? $this->router->generate($route, ['slug' => $slug]) : null,
                'imageSrc'       => $imageName ? $this->storage->resolveUri($item, 'imageFile') : null,
                'prix'           => $type === 'produit' && method_exists($item, 'getPrix') && $item->getPrix() !== null
                    ? number_format($item->getPrix(), 2, ',', ' ') . ' €'
                    : null,
                'rating'         => $type === 'produit' ? ($this->ratingsMap[$id] ?? null) : null,
                'produitId'      => $type === 'produit' ? $id : null,
                'difficulte'     => $type === 'recette' && method_exists($item, 'getDifficulte') && $item->getDifficulte()
                    ? $item->getDifficulte()->value
                    : '',
                'temps'          => $type === 'recette' && method_exists($item, 'getTemps') ? $item->getTemps() : null,
                'portions'       => $type === 'recette' && method_exists($item, 'getPortions') ? $item->getPortions() : null,
                'categorieLabel' => method_exists($item, 'getCategorie') && $item->getCategorie() ? $item->getCategorie()->getNom() : null,
                'favori'         => $id !== null && in_array($id, $this->favorisIds),
                'favoriUrl'      => $id !== null ? $this->router->generate('app_favori_toggle', ['type' => $type, 'id' => $id]) : null,
            ];
        }, $items);
    }

    public function getNormalizedItems(): array
    {
        return $this->normalizedItems;
    }

    public function getTitleId(): string
    {
        $base = $this->id ?: 'product-card-grid';
        return $base . '-title';
    }
}
