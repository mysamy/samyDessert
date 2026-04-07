<?php

namespace App\Controller;

use App\Enum\StatutCommande;
use App\Repository\CommandeRepository;
use App\Service\MailerService;
use Doctrine\ORM\EntityManagerInterface;
use Stripe\Event;
use Stripe\Stripe;
use Stripe\Webhook;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

// Reçoit les événements Stripe en temps réel (serveur → serveur)
// Plus fiable que le retour navigateur : fonctionne même si l'utilisateur ferme la fenêtre après paiement
class StripeWebhookController extends AbstractController
{
    public function __construct(
        private EntityManagerInterface $em,
        private CommandeRepository $commandeRepo,
        private MailerService $mailer,
    ) {}

    // Stripe envoie un POST ici pour chaque événement (checkout.session.completed, etc.)
    #[Route('/webhook/stripe', name: 'app_webhook_stripe', methods: ['POST'])]
    public function handle(Request $request): Response
    {
        Stripe::setApiKey($this->getParameter('stripe_secret_key'));

        $payload = $request->getContent();
        $sigHeader = $request->headers->get('Stripe-Signature', '');
        $webhookSecret = $this->getParameter('stripe_webhook_secret');

        // Vérifier la signature HMAC pour s'assurer que la requête vient bien de Stripe
        try {
            $event = Webhook::constructEvent($payload, $sigHeader, $webhookSecret);
        } catch (\Exception) {
            return new Response('Signature invalide', Response::HTTP_BAD_REQUEST);
        }

        if ($event->type === 'checkout.session.completed') {
            $stripeSession = $event->data->object;
            $commande = $this->commandeRepo->findOneByStripeSessionId($stripeSession->id);

            // Idempotence : ne traiter que si la commande est encore en attente
            if ($commande && $commande->getStatut() === StatutCommande::EnAttente) {
                $commande->setStatut(StatutCommande::Confirmee);
                $this->em->flush();
                $this->mailer->envoyerConfirmationCommande($commande);
            }
        }

        return new Response('OK', Response::HTTP_OK);
    }
}
