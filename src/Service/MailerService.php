<?php

namespace App\Service;

use App\Entity\Commande;
use App\Entity\Utilisateur;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mime\Part\DataPart;
use Twig\Environment;

// Service d'envoi d'emails — centralise tous les emails transactionnels du site
class MailerService
{
    public function __construct(
        private MailerInterface $mailer,
        private Environment $twig,
        private FactureService $factureService,
        private string $mailerFrom,
    ) {}

    // Envoie un email de confirmation d'inscription avec le lien de vérification
    public function envoyerConfirmationInscription(Utilisateur $utilisateur, string $confirmationUrl): void
    {
        $email = (new Email())
            ->from($this->mailerFrom)
            ->to($utilisateur->getEmail())
            ->subject('Confirmez votre adresse email — SamyDessert')
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
            ->subject('Bienvenue chez SamyDessert !')
            ->html($this->twig->render('emails/bienvenue.html.twig', [
                'utilisateur' => $utilisateur,
            ]));

        $this->mailer->send($email);
    }

    // Envoie un email de confirmation de commande avec la facture PDF en pièce jointe
    public function envoyerConfirmationCommande(Commande $commande): void
    {
        $nomFichier = 'facture-' . ($commande->getReference() ?? $commande->getId()) . '.pdf';

        $email = (new Email())
            ->from($this->mailerFrom)
            ->to($commande->getUtilisateur()->getEmail())
            ->subject('Confirmation de votre commande — SamyDessert')
            ->html($this->twig->render('emails/confirmation_commande.html.twig', [
                'commande' => $commande,
            ]))
            ->addPart(new DataPart($this->factureService->genererPdf($commande), $nomFichier, 'application/pdf'));

        $this->mailer->send($email);
    }

    // Envoie le message du formulaire de contact à l'adresse de l'expéditeur configuré
    public function envoyerMessageContact(string $nom, string $email, string $sujet, string $message): void
    {
        $mail = (new Email())
            ->from($this->mailerFrom)
            ->to($this->mailerFrom)
            ->replyTo($email)
            ->subject('[Contact] ' . $sujet . ' — ' . $nom)
            ->html('<p><strong>De :</strong> ' . htmlspecialchars($nom) . ' &lt;' . htmlspecialchars($email) . '&gt;</p>'
                . '<p><strong>Sujet :</strong> ' . htmlspecialchars($sujet) . '</p>'
                . '<p><strong>Message :</strong></p>'
                . '<p>' . nl2br(htmlspecialchars($message)) . '</p>');

        $this->mailer->send($mail);
    }

    // Envoie un email de confirmation d'annulation de commande
    public function envoyerAnnulationCommande(Commande $commande): void
    {
        $email = (new Email())
            ->from($this->mailerFrom)
            ->to($commande->getUtilisateur()->getEmail())
            ->subject('Annulation de votre commande — SamyDessert')
            ->html($this->twig->render('emails/annulation_commande.html.twig', [
                'commande' => $commande,
            ]));

        $this->mailer->send($email);
    }
}