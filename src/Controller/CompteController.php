<?php

namespace App\Controller;

use App\Entity\Commande;
use App\Enum\StatutCommande;
use App\Service\MailerService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Csrf\CsrfToken;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_USER')]
#[Route('/mon-compte', name: 'app_compte_')]
class CompteController extends AbstractController
{
    public function __construct(
        private EntityManagerInterface $em,
        private MailerService $mailer,
    ) {}

    // Page principale du compte utilisateur
    #[Route('', name: 'index')]
    public function index(): Response
    {
        return $this->render('compte/index.html.twig', [
            'utilisateur' => $this->getUser(),
        ]);
    }

    // Liste toutes les commandes de l'utilisateur connecté
    #[Route('/commandes', name: 'commandes')]
    public function commandes(): Response
    {
        $commandes = $this->em->getRepository(Commande::class)->findBy(
            ['utilisateur' => $this->getUser()],
            ['dateCommande' => 'DESC']
        );

        return $this->render('compte/commandes.html.twig', [
            'commandes' => $commandes,
        ]);
    }

    // Annule une commande si elle appartient à l'utilisateur et est encore annulable
    #[Route('/commandes/{id}/annuler', name: 'annuler_commande', methods: ['POST'])]
    public function annulerCommande(Commande $commande, Request $request, CsrfTokenManagerInterface $csrfTokenManager): Response
    {
        // Vérifie le token CSRF pour éviter les attaques CSRF
        $token = new CsrfToken('annuler_commande_' . $commande->getId(), $request->request->get('_token'));
        if (!$csrfTokenManager->isTokenValid($token)) {
            throw $this->createAccessDeniedException('Token CSRF invalide.');
        }

        // Vérifie que la commande appartient bien à l'utilisateur connecté
        if ($commande->getUtilisateur() !== $this->getUser()) {
            throw $this->createAccessDeniedException();
        }

        // Seules les commandes confirmées peuvent être annulées
        if ($commande->getStatut() !== StatutCommande::Confirmee) {
            $this->addFlash('error', 'Cette commande ne peut pas être annulée.');
            return $this->redirectToRoute('app_compte_commandes');
        }

        $commande->setStatut(StatutCommande::Annulee);
        $this->em->flush();

        $this->mailer->envoyerAnnulationCommande($commande);

        $this->addFlash('success', 'Votre commande a bien été annulée.');
        return $this->redirectToRoute('app_compte_commandes');
    }
}
