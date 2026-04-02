<?php

namespace App\Controller;

use App\Service\PanierService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

// Contrôleur du panier : affichage et actions (ajouter, retirer, supprimer, vider)
// Le panier est stocké en session via PanierService, sans base de données
#[Route('/panier', name: 'app_panier_')]
final class PanierController extends AbstractController
{
    // Affiche le contenu du panier
    #[Route('', name: 'index')]
    public function index(PanierService $panier): Response
    {
        return $this->render('panier/index.html.twig', [
            'lignes' => $panier->getLignes(),
            'total'  => $panier->getTotal(),
        ]);
    }

    // Ajoute 1 exemplaire d'un produit et redirige vers le panier
    #[Route('/ajouter/{id}', name: 'ajouter', methods: ['POST'])]
    public function ajouter(int $id, PanierService $panier): RedirectResponse
    {
        $panier->ajouter($id);
        $this->addFlash('success', 'Produit ajouté au panier.');
        return $this->redirectToRoute('app_panier_index');
    }

    // Retire 1 exemplaire d'un produit
    #[Route('/retirer/{id}', name: 'retirer', methods: ['POST'])]
    public function retirer(int $id, PanierService $panier): RedirectResponse
    {
        $panier->retirer($id);
        return $this->redirectToRoute('app_panier_index');
    }

    // Supprime complètement un produit du panier
    #[Route('/supprimer/{id}', name: 'supprimer', methods: ['POST'])]
    public function supprimer(int $id, PanierService $panier): RedirectResponse
    {
        $panier->supprimer($id);
        return $this->redirectToRoute('app_panier_index');
    }

    // Vide tout le panier
    #[Route('/vider', name: 'vider', methods: ['POST'])]
    public function vider(PanierService $panier): RedirectResponse
    {
        $panier->vider();
        $this->addFlash('info', 'Votre panier a été vidé.');
        return $this->redirectToRoute('app_panier_index');
    }
}
