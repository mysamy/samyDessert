<?php

namespace App\Controller;

use App\Entity\Commande;
use App\Entity\CommandeProduit;
use App\Enum\StatutCommande;
use App\Service\MailerService;
use App\Service\PanierService;
use Doctrine\ORM\EntityManagerInterface;
use Stripe\Checkout\Session;
use Stripe\Stripe;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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
        private MailerService $mailer,
    ) {}

    // Étape 1 : saisie de l'adresse de livraison
    #[Route('/commande/adresse', name: 'app_commande_adresse')]
    public function adresse(Request $request): Response
    {
        $lignes = $this->panier->getLignes();
        if (empty($lignes)) {
            return $this->redirectToRoute('app_panier_index');
        }

        $user = $this->getUser();
        $session = $request->getSession();
        $errors = [];
        $values = $session->get('adresse_livraison', []);

        if ($request->isMethod('POST')) {
            if (!$this->isCsrfTokenValid('adresse', $request->request->get('_token'))) {
                throw $this->createAccessDeniedException();
            }

            $values = [
                'firstName'  => trim($request->request->get('firstName', '')),
                'lastName'   => trim($request->request->get('lastName', '')),
                'address1'   => trim($request->request->get('address1', '')),
                'postalCode' => trim($request->request->get('postalCode', '')),
                'city'       => trim($request->request->get('city', '')),
                'country'    => $request->request->get('country', 'FR'),
                'phone'      => trim($request->request->get('phone', '')),
                'notes'      => trim($request->request->get('notes', '')),
            ];

            if ($values['firstName'] === '') { $errors['firstName'] = 'Le prénom est obligatoire.'; }
            if ($values['lastName'] === '')  { $errors['lastName']  = 'Le nom est obligatoire.'; }
            if ($values['address1'] === '')  { $errors['address1']  = 'L\'adresse est obligatoire.'; }
            if ($values['postalCode'] === '') { $errors['postalCode'] = 'Le code postal est obligatoire.'; }
            if ($values['city'] === '')      { $errors['city']      = 'La ville est obligatoire.'; }

            if (empty($errors)) {
                $session->set('adresse_livraison', $values);
                return $this->redirectToRoute('app_commande');
            }
        }

        // Pré-remplir depuis le profil utilisateur si pas encore de données en session
        if (empty($values)) {
            $values = [
                'firstName'  => $user->getPrenom() ?? '',
                'lastName'   => $user->getNom() ?? '',
                'address1'   => $user->getAdresse() ?? '',
                'postalCode' => $user->getCodePostal() ?? '',
                'city'       => $user->getVille() ?? '',
                'country'    => 'FR',
                'phone'      => $user->getTelephone() ?? '',
                'notes'      => '',
            ];
        }

        return $this->render('commande/adresse.html.twig', [
            'values' => $values,
            'errors' => $errors,
        ]);
    }

    // Étape 2 : récapitulatif avant paiement
    #[Route('/commande', name: 'app_commande')]
    public function index(Request $request): Response
    {
        $lignes = $this->panier->getLignes();
        if (empty($lignes)) {
            return $this->redirectToRoute('app_panier_index');
        }

        if (!$request->getSession()->has('adresse_livraison')) {
            return $this->redirectToRoute('app_commande_adresse');
        }

        return $this->render('commande/index.html.twig', [
            'lignes'  => $lignes,
            'total'   => $this->panier->getTotal(),
            'adresse' => $request->getSession()->get('adresse_livraison'),
        ]);
    }

    // Crée la session Stripe Checkout et redirige vers la page de paiement Stripe
    #[Route('/commande/paiement', name: 'app_commande_paiement', methods: ['POST'])]
    public function paiement(): Response
    {
        $lignes = $this->panier->getLignes();

        if (empty($lignes)) {
            return $this->redirectToRoute('app_panier_index');
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
    public function succes(Request $request): Response
    {
        $lignes = $this->panier->getLignes();

        if (!empty($lignes)) {
            $commande = new Commande();
            $commande->setUtilisateur($this->getUser());
            $commande->setStatut(StatutCommande::Confirmee);
            $commande->setTotal((string) $this->panier->getTotal());

            // Sauvegarde l'adresse de livraison depuis la session
            $adresse = $request->getSession()->get('adresse_livraison', []);
            if (!empty($adresse)) {
                $commande->setAdresseLivraison($adresse['address1'] ?? '');
                $commande->setVille($adresse['city'] ?? '');
                $commande->setCodePostal($adresse['postalCode'] ?? '');
                $commande->setNotes($adresse['notes'] ?: null);
                $request->getSession()->remove('adresse_livraison');
            }

            foreach ($lignes as $ligne) {
                $cp = new CommandeProduit();
                $cp->setCommande($commande);
                $cp->setProduit($ligne['produit']);
                $cp->setQuantite($ligne['quantite']);
                $cp->setPrixUnitaire((string) $ligne['produit']->getPrix());
                $this->em->persist($cp);
            }

            // Génère une référence lisible ex: CMD-2026-00001
            $commande->setReference('CMD-' . date('Y') . '-' . str_pad((string) random_int(1, 99999), 5, '0', STR_PAD_LEFT));

            $this->em->persist($commande);
            $this->em->flush();

            $this->panier->vider();
            $this->mailer->envoyerConfirmationCommande($commande);
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
