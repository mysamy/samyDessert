<?php

namespace App\Controller;

use App\Repository\CategorieRepository;
use App\Repository\ProduitRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

// Contrôleur de la page produits (route "/produits")
final class ProduitsController extends AbstractController
{
    // Affiche la liste des produits avec filtre par catégorie et recherche par nom
    #[Route('/produits', name: 'app_produits')]
    public function index(Request $request, ProduitRepository $produitRepo): Response
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

        $produitsEntites = $qb->getQuery()->getResult();

        // Convertit les entités Produit au format attendu par le template
        $produits = array_map(fn($p) => [
            'title'    => $p->getNom(),
            'imageSrc' => $p->getImageSrc() ?? '/assets/image/étape1img.png',
            'price'    => (float) $p->getPrix(),
            'rating'   => 5, // TODO: calculer depuis les avis en base
        ], $produitsEntites);

        return $this->render('produits/index.html.twig', [
            'produits'        => $produits,
            'categories'      => $categories,
            'categorieActive' => $categorieActive,
            'recherche'       => $recherche,
        ]);
    }
}
