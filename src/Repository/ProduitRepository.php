<?php

namespace App\Repository;

use App\Entity\CommandeProduit;
use App\Entity\Produit;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Produit>
 */
// Repository Produit : permet d'effectuer des requêtes sur la table des produits
class ProduitRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Produit::class);
    }

    /**
     * Retourne les produits les plus vendus (par quantité totale commandée).
     * Si aucune commande n'existe encore, retourne les produits disponibles les plus récents.
     *
     * @return Produit[]
     */
    public function findMeilleursVendus(int $limit = 4): array
    {
        $results = $this->createQueryBuilder('p')
            ->leftJoin(CommandeProduit::class, 'cp', 'WITH', 'cp.produit = p')
            ->andWhere('p.disponible = true')
            ->groupBy('p.id')
            ->orderBy('SUM(cp.quantite)', 'DESC')
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult();

        // Si pas encore de commandes, fallback sur les produits les plus récents
        if (empty($results)) {
            return $this->createQueryBuilder('p')
                ->andWhere('p.disponible = true')
                ->orderBy('p.createdAt', 'DESC')
                ->setMaxResults($limit)
                ->getQuery()
                ->getResult();
        }

        return $results;
    }

    /**
     * Retourne les produits correspondant aux slugs donnés, dans l'ordre des slugs.
     *
     * @param string[] $slugs
     * @return Produit[]
     */
    public function findBySlugsOrdered(array $slugs): array
    {
        $produits = $this->createQueryBuilder('p')
            ->andWhere('p.slug IN (:slugs)')
            ->setParameter('slugs', $slugs)
            ->getQuery()
            ->getResult();

        // Remettre dans l'ordre des slugs demandés
        $indexed = [];
        foreach ($produits as $p) {
            $indexed[$p->getSlug()] = $p;
        }
        $ordered = [];
        foreach ($slugs as $slug) {
            if (isset($indexed[$slug])) {
                $ordered[] = $indexed[$slug];
            }
        }
        return $ordered;
    }
}