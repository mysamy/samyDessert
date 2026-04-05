<?php

namespace App\Controller;

use App\Entity\Recette;
use App\Entity\Utilisateur;
use App\Repository\RecetteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

// Contrôleur des pages recettes : liste (/recettes) et détail (/recettes/{slug})
final class RecettesController extends AbstractController
{
    // Affiche la liste des recettes avec filtre par catégorie et recherche par mot-clé
    #[Route('/recettes', name: 'app_recettes')]
    public function index(Request $request, RecetteRepository $recetteRepo): Response
    {
        $recherche       = trim($request->query->get('q', ''));
        $categorieActive = $request->query->get('categorie', '');
        $tri             = $request->query->get('tri', '');

        $categories = [
            'tartes'       => 'Tartes',
            'choux'        => 'Choux & Éclairs',
            'petits-fours' => 'Petits Gâteaux',
            'entremets'    => 'Gâteaux',
        ];

        // Requête Doctrine : uniquement les recettes publiées
        $qb = $recetteRepo->createQueryBuilder('r')
            ->leftJoin('r.categorie', 'c')
            ->where('r.isPublished = true');

        if ($categorieActive && isset($categories[$categorieActive])) {
            $qb->andWhere('c.nom = :nomCategorie')
               ->setParameter('nomCategorie', $categories[$categorieActive]);
        }

        if ($recherche) {
            $qb->andWhere('r.titre LIKE :recherche OR r.description LIKE :recherche')
               ->setParameter('recherche', '%' . $recherche . '%');
        }

        if ($tri !== 'difficulte_asc' && $tri !== 'difficulte_desc') {
            $qb->orderBy('r.createdAt', 'DESC');
        }

        $recettes = $qb->getQuery()->getResult();

        // Tri par difficulté (facile < moyen < difficile)
        if ($tri === 'difficulte_asc' || $tri === 'difficulte_desc') {
            $ordre = ['facile' => 1, 'moyen' => 2, 'difficile' => 3];
            usort($recettes, function ($a, $b) use ($ordre, $tri) {
                $va = $ordre[$a->getDifficulte()?->value ?? ''] ?? 0;
                $vb = $ordre[$b->getDifficulte()?->value ?? ''] ?? 0;
                return $tri === 'difficulte_asc' ? $va <=> $vb : $vb <=> $va;
            });
        }

        // Récupère les IDs des recettes favorites de l'utilisateur connecté
        $user = $this->getUser();
        $recettesFavorisIds = [];
        if ($user instanceof Utilisateur) {
            $recettesFavorisIds = $user->getRecettesFavoris()->map(fn($r) => $r->getId())->toArray();
        }

        return $this->render('recettes/index.html.twig', [
            'recettes'           => $recettes,
            'categories'         => $categories,
            'categorieActive'    => $categorieActive,
            'recherche'          => $recherche,
            'tri'                => $tri,
            'recettesFavorisIds' => $recettesFavorisIds,
        ]);
    }

    // Affiche la page de détail d'une recette avec les étapes
    #[Route('/recettes/{slug}', name: 'app_recette_show')]
    public function show(string $slug, RecetteRepository $recetteRepo): Response
    {
        $recette = $recetteRepo->findOneBy(['slug' => $slug]);
        if (!$recette) {
            throw $this->createNotFoundException('Recette introuvable.');
        }

        return $this->render('recettes/show.html.twig', [
            'recette' => $recette,
        ]);
    }
}
