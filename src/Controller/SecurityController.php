<?php

namespace App\Controller;

use App\Entity\Utilisateur;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

// Contrôleur pour l'authentification (connexion et inscription)
final class SecurityController extends AbstractController
{
    // Affiche la page de connexion (route "/connexion")
    #[Route('/connexion', name: 'app_login')]
    public function login(AuthenticationUtils $authUtils): Response
    {
        $error = $authUtils->getLastAuthenticationError();
        $lastUsername = $authUtils->getLastUsername();

        return $this->render('security/login.html.twig', [
            'error'        => $error,
            'lastUsername' => $lastUsername,
        ]);
    }

    // Gère l'affichage et la soumission du formulaire d'inscription
    #[Route('/inscription', name: 'app_register', methods: ['GET', 'POST'])]
    public function register(
        Request $request,
        UserPasswordHasherInterface $hasher,
        EntityManagerInterface $em
    ): Response {
        $error = null;

        if ($request->isMethod('POST')) {
            $email    = $request->request->get('email', '');
            $password = $request->request->get('password', '');
            $confirm  = $request->request->get('password_confirm', '');
            $nom      = $request->request->get('nom', '');
            $prenom   = $request->request->get('prenom', '');

            if ($password !== $confirm) {
                $error = 'Les mots de passe ne correspondent pas.';
            } elseif (strlen($password) < 8) {
                $error = 'Le mot de passe doit contenir au moins 8 caractères.';
            } elseif ($em->getRepository(Utilisateur::class)->findOneBy(['email' => $email])) {
                $error = 'Cette adresse email est déjà utilisée.';
            } else {
                $user = new Utilisateur();
                $user->setEmail($email);
                $user->setNom($nom ?: null);
                $user->setPrenom($prenom ?: null);
                $user->setPassword($hasher->hashPassword($user, $password));

                $em->persist($user);
                $em->flush();

                return $this->redirectToRoute('app_login');
            }
        }

        return $this->render('security/register.html.twig', [
            'error' => $error,
        ]);
    }
}
