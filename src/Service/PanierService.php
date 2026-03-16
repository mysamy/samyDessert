<?php

namespace App\Service;

use App\Entity\Produit;
use App\Repository\ProduitRepository;
use Symfony\Component\HttpFoundation\RequestStack;

// Gère le panier stocké en session.
// Structure : $_SESSION['panier'] = [ produitId => quantite, ... ]
class PanierService
{
    public function __construct(
        private RequestStack $requestStack,
        private ProduitRepository $produitRepository,
    ) {}

    // Retourne le contenu brut de la session : [id => quantite]
    private function getPanierSession(): array
    {
        return $this->requestStack->getSession()->get('panier', []);
    }

    private function savePanier(array $panier): void
    {
        $this->requestStack->getSession()->set('panier', $panier);
    }

    // Retourne la quantité d'un produit spécifique (lecture session uniquement, pas de SQL)
    public function getQuantitePourProduit(int $produitId): int
    {
        return $this->getPanierSession()[$produitId] ?? 0;
    }

    // Ajoute 1 exemplaire d'un produit au panier
    public function ajouter(int $produitId): void
    {
        $panier = $this->getPanierSession();
        $panier[$produitId] = ($panier[$produitId] ?? 0) + 1;
        $this->savePanier($panier);
    }

    // Retire 1 exemplaire — supprime la ligne si quantité tombe à 0
    public function retirer(int $produitId): void
    {
        $panier = $this->getPanierSession();
        if (!isset($panier[$produitId])) return;

        $panier[$produitId]--;
        if ($panier[$produitId] <= 0) {
            unset($panier[$produitId]);
        }
        $this->savePanier($panier);
    }

    // Supprime complètement un produit du panier
    public function supprimer(int $produitId): void
    {
        $panier = $this->getPanierSession();
        unset($panier[$produitId]);
        $this->savePanier($panier);
    }

    // Vide entièrement le panier
    public function vider(): void
    {
        $this->savePanier([]);
    }

    // Retourne les lignes du panier enrichies avec les entités Produit :
    // [ ['produit' => Produit, 'quantite' => int], ... ]
    public function getLignes(): array
    {
        $panier = $this->getPanierSession();
        if (empty($panier)) return [];

        $produits = $this->produitRepository->findBy(['id' => array_keys($panier)]);

        $lignes = [];
        foreach ($produits as $produit) {
            $lignes[] = [
                'produit'  => $produit,
                'quantite' => $panier[$produit->getId()],
            ];
        }

        return $lignes;
    }

    // Calcule le total du panier en euros
    public function getTotal(): float
    {
        $total = 0.0;
        foreach ($this->getLignes() as $ligne) {
            $total += (float) $ligne['produit']->getPrix() * $ligne['quantite'];
        }
        return $total;
    }

    // Nombre total d'articles (toutes quantités confondues)
    public function getNombreArticles(): int
    {
        return array_sum($this->getPanierSession());
    }
}
