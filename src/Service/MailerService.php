<?php

namespace App\Service;

use App\Entity\Commande;
use App\Entity\Utilisateur;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Twig\Environment;

// Service d'envoi d'emails — centralise tous les emails transactionnels du site
class MailerService
{
    public function __construct(
        private MailerInterface $mailer,
        private Environment $twig,
        private string $mailerFrom,
    ) {}

    // Envoie un email de confirmation d'inscription avec le lien de vérification
    public function envoyerConfirmationInscription(Utilisateur $utilisateur, string $confirmationUrl): void
    {
        $email = (new Email())
            ->from($this->mailerFrom)
            ->to($utilisateur->getEmail())
            ->subject('Confirmez votre adresse email — Samy Dessert')
            ->html($this->twig->render('emails/confirmation_inscription.html.twig', [
                'utilisateur'     => $utilisateur,
                'confirmationUrl' => $confirmationUrl,
            ]));

        $this->mailer->send($email);
    }

    // Envoie un email de bienvenue une fois le compte confirmé
    public function envoyerBienvenue(Utilisateur $utilisateur): void
    {
        $email = (new Email())
            ->from($this->mailerFrom)
            ->to($utilisateur->getEmail())
            ->subject('Bienvenue chez Samy Dessert !')
            ->html($this->twig->render('emails/bienvenue.html.twig', [
                'utilisateur' => $utilisateur,
            ]));

        $this->mailer->send($email);
    }

    // Envoie un email de confirmation de commande au client
    public function envoyerConfirmationCommande(Commande $commande): void
    {
        $email = (new Email())
            ->from($this->mailerFrom)
            ->to($commande->getUtilisateur()->getEmail())
            ->subject('Confirmation de votre commande — Samy Dessert')
            ->html($this->twig->render('emails/confirmation_commande.html.twig', [
                'commande' => $commande,
            ]));

        $this->mailer->send($email);
    }
}