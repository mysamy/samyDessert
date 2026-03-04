<?php

namespace App\Twig\Components\Organisms;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent]
final class CartSummary
{
    public string $id = 'cart-summary';
    public string $class = 'space-y-4';

    public array $items = [];

    public string $currency = '€';

    public string $checkoutLabel = 'Commander';
    public ?string $checkoutUrl = null;

    public function isEmpty(): bool
    {
        return empty($this->items);
    }

    public function getTotalItems(): int
    {
        return array_sum(array_column($this->items, 'quantity'));
    }

    public function getTotalPrice(): float
    {
        return array_sum(array_map(
            fn($item) => ($item['quantity'] ?? 0) * ($item['price'] ?? 0),
            $this->items
        ));
    }
}
