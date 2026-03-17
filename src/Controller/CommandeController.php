<?php

namespace App\Controller;

use App\Entity\Commande;
use App\Entity\CommandeProduit;
use App\Enum\StatutCommande;
use App\Service\PanierService;
use Doctrine\ORM\EntityManagerInterface;
use Stripe\Checkout\Session;
use Stripe\Stripe;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_USER')]
class CommandeController extends AbstractController
{
    public function __construct(
        private PanierService $panier,
        private EntityManagerInterface $em,
    ) {}

    // Page récap + formulaire adresse avant paiement
    #[Route('/commande', name: 'app_commande')]
    public function index(): Response
    {
        $lignes = $this->panier->getLignes();

        if (empty($lignes)) {
            return $this->redirectToRoute('app_panier');
        }

        return $this->render('commande/index.html.twig', [
            'lignes' => $lignes,
            'total'  => $this->panier->getTotal(),
        ]);
    }

    // Crée la session Stripe Checkout et redirige vers la page de paiement Stripe
    #[Route('/commande/paiement', name: 'app_commande_paiement', methods: ['POST'])]
    public function paiement(): Response
    {
        $lignes = $this->panier->getLignes();

        if (empty($lignes)) {
            return $this->redirectToRoute('app_panier');
        }

        Stripe::setApiKey($this->getParameter('stripe_secret_key'));

        // Construit les line_items Stripe depuis le panier
        $lineItems = [];
        foreach ($lignes as $ligne) {
            $lineItems[] = [
                'price_data' => [
                    'currency'     => 'eur',
                    'unit_amount'  => (int) round((float) $ligne['produit']->getPrix() * 100),
                    'product_data' => [
                        'name' => $ligne['produit']->getNom(),
                    ],
                ],
                'quantity' => $ligne['quantite'],
            ];
        }

        $session = Session::create([
            'payment_method_types' => ['card'],
            'line_items'           => $lineItems,
            'mode'                 => 'payment',
            'success_url'          => $this->generateUrl('app_commande_succes', [], UrlGeneratorInterface::ABSOLUTE_URL) . '?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url'           => $this->generateUrl('app_commande_annulation', [], UrlGeneratorInterface::ABSOLUTE_URL),
            'customer_email'       => $this->getUser()->getUserIdentifier(),
        ]);

        return $this->redirect($session->url, 303);
    }

    // Stripe redirige ici après un paiement réussi
    #[Route('/commande/succes', name: 'app_commande_succes')]
    public function succes(): Response
    {
        $lignes = $this->panier->getLignes();

        if (!empty($lignes)) {
            $commande = new Commande();
            $commande->setUtilisateur($this->getUser());
            $commande->setStatut(StatutCommande::Confirmee);
            $commande->setTotal((string) $this->panier->getTotal());

            foreach ($lignes as $ligne) {
                $cp = new CommandeProduit();
                $cp->setCommande($commande);
                $cp->setProduit($ligne['produit']);
                $cp->setQuantite($ligne['quantite']);
                $cp->setPrixUnitaire((string) $ligne['produit']->getPrix());
                $this->em->persist($cp);
            }

            $this->em->persist($commande);
            $this->em->flush();

            $this->panier->vider();
        }

        return $this->render('commande/succes.html.twig');
    }

    // Stripe redirige ici si l'utilisateur annule le paiement
    #[Route('/commande/annulation', name: 'app_commande_annulation')]
    public function annulation(): Response
    {
        return $this->render('commande/annulation.html.twig');
    }
}
