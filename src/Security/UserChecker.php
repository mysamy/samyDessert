<?php

namespace App\Security;

use App\Entity\Utilisateur;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAccountStatusException;
use Symfony\Component\Security\Core\User\UserCheckerInterface;
use Symfony\Component\Security\Core\User\UserInterface;

// Vérifie l'état du compte avant d'autoriser la connexion
class UserChecker implements UserCheckerInterface
{
    // Appelé avant la vérification du mot de passe
    public function checkPreAuth(UserInterface $user): void
    {
        if (!$user instanceof Utilisateur) {
            return;
        }

        if (!$user->isVerified()) {
            throw new CustomUserMessageAccountStatusException(
                'Votre compte n\'est pas encore activé. Vérifiez votre email.'
            );
        }
    }

    // Appelé après la vérification du mot de passe (non utilisé ici)
    public function checkPostAuth(UserInterface $user): void {}
}