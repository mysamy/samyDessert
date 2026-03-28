<?php

namespace App\Controller;

use App\Entity\Utilisateur;
use App\Service\MailerService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

// Contrôleur pour l'authentification (connexion, inscription, vérification email)
final class SecurityController extends AbstractController
{
    // Affiche la page de connexion (route "/connexion")
    #[Route('/connexion', name: 'app_login')]
    public function login(AuthenticationUtils $authUtils): Response
    {
        $error = $authUtils->getLastAuthenticationError();
        $lastUsername = $authUtils->getLastUsername() ?? '';

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
        EntityManagerInterface $em,
        MailerService $mailer,
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
                // Génère un token aléatoire de 64 caractères hexadécimaux
                $token = bin2hex(random_bytes(32));

                $user = new Utilisateur();
                $user->setEmail($email);
                $user->setNom($nom ?: null);
                $user->setPrenom($prenom ?: null);
                $user->setPassword($hasher->hashPassword($user, $password));
                $user->setVerificationToken($token);
                // isVerified reste false jusqu'au clic sur le lien

                $em->persist($user);
                $em->flush();

                // Génère l'URL absolue vers la route de confirmation
                $confirmationUrl = $this->generateUrl(
                    'app_confirm_email',
                    ['token' => $token],
                    UrlGeneratorInterface::ABSOLUTE_URL,
                );

                $mailer->envoyerConfirmationInscription($user, $confirmationUrl);

                return $this->render('security/register_check_email.html.twig', [
                    'email' => $email,
                ]);
            }
        }

        return $this->render('security/register.html.twig', [
            'error'  => $error,
            'values' => [
                'email'  => $email ?? '',
                'nom'    => $nom ?? '',
                'prenom' => $prenom ?? '',
            ],
        ]);
    }

    // Vérifie le token reçu par email et active le compte
    #[Route('/confirmer-email/{token}', name: 'app_confirm_email')]
    public function confirmerEmail(
        string $token,
        EntityManagerInterface $em,
        MailerService $mailer,
    ): Response {
        $user = $em->getRepository(Utilisateur::class)->findOneBy(['verificationToken' => $token]);

        if (!$user) {
            // Token invalide ou déjà utilisé
            return $this->render('security/confirm_invalid.html.twig');
        }

        $user->setIsVerified(true);
        $user->setVerificationToken(null); // on efface le token, il ne peut plus resservir
        $em->flush();

        $mailer->envoyerBienvenue($user);

        $this->addFlash('success', 'Votre adresse email a été confirmée. Vous pouvez maintenant vous connecter.');

        return $this->redirectToRoute('app_login');
    }
}