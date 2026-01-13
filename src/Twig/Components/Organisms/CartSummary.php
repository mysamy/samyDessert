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
    public int $totalItems = 0;
    public float $totalPrice = 0.0;

    public string $checkoutLabel = 'Commander';
    public ?string $checkoutUrl = null;

    public bool $empty = false;
}
