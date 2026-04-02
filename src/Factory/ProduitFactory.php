<?php

namespace App\Factory;

use App\Entity\Produit;
use Zenstruck\Foundry\Persistence\PersistentObjectFactory;

/**
 * @extends PersistentObjectFactory<Produit>
 */
final class ProduitFactory extends PersistentObjectFactory
{
    public static function class(): string
    {
        return Produit::class;
    }

    protected function defaults(): array
    {
        return [
            'nom'         => self::faker()->words(3, true),
            'description' => self::faker()->sentence(),
            'prix'        => (string) self::faker()->randomFloat(2, 2, 50),
            'disponible'  => true,
        ];
    }

    // Raccourci : produit avec prix fixe
    public function avecPrix(string $prix): static
    {
        return $this->with(['prix' => $prix]);
    }

    // Raccourci : produit indisponible
    public function indisponible(): static
    {
        return $this->with(['disponible' => false]);
    }
}
