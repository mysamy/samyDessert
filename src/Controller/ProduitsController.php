<?php

namespace App\Controller;

use App\Entity\Produit;
use App\Entity\Utilisateur;
use App\Repository\AvisRepository;
use App\Repository\ProduitRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

// Contrôleur des pages produits : liste (/produits) et détail (/produits/{slug})
final class ProduitsController extends AbstractController
{
    // Affiche la liste des produits avec filtre par catégorie et recherche par nom
    #[Route('/produits', name: 'app_produits')]
    public function index(Request $request, ProduitRepository $produitRepo, AvisRepository $avisRepo): Response
    {
        $recherche       = trim($request->query->get('q', ''));
        $categorieActive = $request->query->get('categorie', '');

        // Map slug URL → nom en base (correspond aux fixtures)
        $categories = [
            'tartes'       => 'Tartes',
            'choux'        => 'Choux & Éclairs',
            'petits-fours' => 'Petits fours',
            'entremets'    => 'Entremets',
        ];

        // Construit la requête Doctrine avec les filtres actifs
        $qb = $produitRepo->createQueryBuilder('p')
            ->leftJoin('p.categorie', 'c')
            ->where('p.disponible = true');

        // Filtre par catégorie si un slug est sélectionné
        if ($categorieActive && isset($categories[$categorieActive])) {
            $qb->andWhere('c.nom = :nomCategorie')
               ->setParameter('nomCategorie', $categories[$categorieActive]);
        }

        // Filtre par nom si une recherche est saisie
        if ($recherche) {
            $qb->andWhere('p.nom LIKE :recherche')
               ->setParameter('recherche', '%' . $recherche . '%');
        }

        $produits = $qb->getQuery()->getResult();

        // Récupère les IDs des produits favoris de l'utilisateur connecté
        $user = $this->getUser();
        $produitsFavorisIds = [];
        if ($user instanceof Utilisateur) {
            $produitsFavorisIds = $user->getProduitsFavoris()->map(fn($p) => $p->getId())->toArray();
        }

        $notesMap = $avisRepo->findNotesMoyennes($produits);

        return $this->render('produits/index.html.twig', [
            'produits'           => $produits,
            'categories'         => $categories,
            'categorieActive'    => $categorieActive,
            'recherche'          => $recherche,
            'produitsFavorisIds' => $produitsFavorisIds,
            'notesMap'           => $notesMap,
        ]);
    }

    // Affiche la page de détail d'un produit
    #[Route('/produits/{slug}', name: 'app_produit_show')]
    public function show(string $slug, ProduitRepository $produitRepo, AvisRepository $avisRepo): Response
    {
        $produit = $produitRepo->findOneBy(['slug' => $slug]);
        if (!$produit) {
            throw $this->createNotFoundException('Produit introuvable.');
        }

        $avis        = $avisRepo->findByProduit($produit);
        $noteMoyenne = $avisRepo->findNoteMoyenne($produit);

        $user    = $this->getUser();
        $monAvis = null;
        if ($user instanceof Utilisateur) {
            $monAvis = $avisRepo->findOneByUserAndProduit($user, $produit);
        }

        return $this->render('produits/show.html.twig', [
            'produit'     => $produit,
            'avis'        => $avis,
            'noteMoyenne' => $noteMoyenne,
            'monAvis'     => $monAvis,
        ]);
    }
}
