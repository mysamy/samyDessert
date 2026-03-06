<?php

namespace App\Twig\Components\Organisms;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent]
final class ProductCard
{
    public ?string $id = null;
    public string $class = '';

    public string $title = '';
    public ?string $url = null;

    public ?string $imageSrc = null;
    public ?string $imageAlt = null;

    public float $price = 0.0;
    public string $currency = '€';

    public ?float $rating = null;
    public ?int $reviewCount = null;

    public string $addToCartLabel = 'Ajouter au panier';
    public ?string $addToCartUrl = null;
    public bool $addToCartDisabled = false;

    public function getComputedId(): string
    {
        if ($this->id !== null && $this->id !== '') {
            return $this->id;
        }

        $seed = $this->title !== '' ? $this->title : 'product-card';
        $id = preg_replace('/[^a-zA-Z0-9\-_:.]+/', '_', $seed);

        return $id ?: 'product-card';
    }

    public function getComputedImageAlt(): string
    {
        if ($this->imageAlt !== null && $this->imageAlt !== '') {
            return $this->imageAlt;
        }

        return $this->title !== '' ? $this->title : 'Produit';
    }

    public function getFormattedPrice(): string
    {
        return number_format($this->price, 2, ',', ' ').$this->currency;
    }

    public function getRatingText(): ?string
    {
        if ($this->rating === null) {
            return null;
        }

        $txt = number_format($this->rating, 1, ',', ' ');

        if ($this->reviewCount !== null) {
            return $txt.' / 5 ('.$this->reviewCount.')';
        }

        return $txt.' / 5';
    }

    public function getRatingAriaLabel(): ?string
    {
        if ($this->rating === null) {
            return null;
        }

        $txt = number_format($this->rating, 1, ',', ' ');
        $count = $this->reviewCount !== null ? ' sur '.$this->reviewCount.' avis' : '';

        return 'Note '.$txt.' sur 5'.$count;
    }

    public function isFilledStar(int $index): bool
    {
        if ($this->rating === null) {
            return false;
        }

        return $this->rating >= $index;
    }
}
