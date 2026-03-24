<?php

namespace App\Controller;

use App\Entity\Produit;
use App\Entity\Recette;
use App\Entity\Utilisateur;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

// Contrôleur pour le toggle favori (produit ou recette) — appelé en AJAX par le Stimulus controller "favori"
final class FavoriController extends AbstractController
{
    #[Route('/favori/{type}/{id}', name: 'app_favori_toggle', methods: ['POST'])]
    public function toggle(string $type, int $id, Request $request, EntityManagerInterface $em): JsonResponse
    {
        // Vérifie que l'utilisateur est connecté
        $user = $this->getUser();
        if (!$user instanceof Utilisateur) {
            return $this->json(['error' => 'Non connecté'], 401);
        }

        // Vérifie que c'est bien un appel AJAX (protection CSRF basique)
        if (!$request->headers->has('X-Requested-With')) {
            return $this->json(['error' => 'Requête invalide'], 400);
        }

        if ($type === 'produit') {
            $entity = $em->getRepository(Produit::class)->find($id);
            if (!$entity) {
                return $this->json(['error' => 'Produit introuvable'], 404);
            }

            if ($user->getProduitsFavoris()->contains($entity)) {
                $user->removeProduitFavori($entity);
                $favori = false;
            } else {
                $user->addProduitFavori($entity);
                $favori = true;
            }
        } elseif ($type === 'recette') {
            $entity = $em->getRepository(Recette::class)->find($id);
            if (!$entity) {
                return $this->json(['error' => 'Recette introuvable'], 404);
            }

            if ($user->getRecettesFavoris()->contains($entity)) {
                $user->removeRecetteFavori($entity);
                $favori = false;
            } else {
                $user->addRecetteFavori($entity);
                $favori = true;
            }
        } else {
            return $this->json(['error' => 'Type invalide'], 400);
        }

        $em->flush();

        return $this->json(['favori' => $favori]);
    }
}
