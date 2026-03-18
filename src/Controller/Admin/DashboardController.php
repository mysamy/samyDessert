<?php

namespace App\Controller\Admin;

use App\Entity\Commande;
use App\Entity\Produit;
use App\Entity\Utilisateur;
use App\Repository\CommandeRepository;
use App\Repository\ProduitRepository;
use App\Repository\UtilisateurRepository;
use EasyCorp\Bundle\EasyAdminBundle\Attribute\AdminDashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_ADMIN')]
#[AdminDashboard(routePath: '/admin', routeName: 'admin')]
class DashboardController extends AbstractDashboardController
{
    public function __construct(
        private ProduitRepository $produitRepository,
        private CommandeRepository $commandeRepository,
        private UtilisateurRepository $utilisateurRepository,
    ) {}

    public function index(): Response
    {
        $commandes = $this->commandeRepository->findBy([], ['dateCommande' => 'DESC'], 50);

        // Regroupe les commandes par date pour le calendrier
        $commandesParDate = [];
        foreach ($commandes as $commande) {
            $date = $commande->getDateCommande()->format('Y-m-d');
            $commandesParDate[$date] = ($commandesParDate[$date] ?? 0) + 1;
        }

        return $this->render('admin/dashboard.html.twig', [
            'nbProduits'    => $this->produitRepository->count([]),
            'nbCommandes'   => $this->commandeRepository->count([]),
            'nbUtilisateurs' => $this->utilisateurRepository->count([]),
            'dernieresCommandes' => array_slice($commandes, 0, 5),
            'commandesParDate'   => $commandesParDate,
        ]);
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Samy Dessert — Administration')
            ->setFaviconPath('/logotest.svg');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Tableau de bord', 'fa fa-home');
        yield MenuItem::linkToRoute('Calendrier', 'fa fa-calendar', 'admin_calendrier');
        yield MenuItem::section('Catalogue');
        yield MenuItem::linkToCrud('Produits', 'fa fa-cake-candles', Produit::class);
        yield MenuItem::section('Ventes');
        yield MenuItem::linkToCrud('Commandes', 'fa fa-bag-shopping', Commande::class);
        yield MenuItem::section('Utilisateurs');
        yield MenuItem::linkToCrud('Utilisateurs', 'fa fa-users', Utilisateur::class);
        yield MenuItem::section('');
        yield MenuItem::linkToRoute('Retour au site', 'fa fa-arrow-left', 'app_home');
    }
}
