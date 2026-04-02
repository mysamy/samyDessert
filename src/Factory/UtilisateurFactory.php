<?php

namespace App\Factory;

use App\Entity\Utilisateur;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Zenstruck\Foundry\Persistence\PersistentObjectFactory;

/**
 * @extends PersistentObjectFactory<Utilisateur>
 */
final class UtilisateurFactory extends PersistentObjectFactory
{
    public function __construct(
        private readonly UserPasswordHasherInterface $hasher,
    ) {
        parent::__construct();
    }

    public static function class(): string
    {
        return Utilisateur::class;
    }

    protected function defaults(): array
    {
        return [
            'email'      => self::faker()->unique()->safeEmail(),
            'nom'        => self::faker()->lastName(),
            'prenom'     => self::faker()->firstName(),
            'isVerified' => true,
            'roles'      => [],
            'password'   => 'placeholder', // remplacé dans initialize()
        ];
    }

    protected function initialize(): static
    {
        return $this->afterInstantiate(function (Utilisateur $user): void {
            $user->setPassword($this->hasher->hashPassword($user, 'motdepasse123'));
        });
    }

    // Raccourci : utilisateur avec mot de passe personnalisé
    public function withPassword(string $plainPassword): static
    {
        return $this->afterInstantiate(function (Utilisateur $user) use ($plainPassword): void {
            $user->setPassword($this->hasher->hashPassword($user, $plainPassword));
        });
    }

    // Raccourci : compte non vérifié (email non confirmé)
    public function nonVerifie(): static
    {
        return $this->with(['isVerified' => false]);
    }
}
