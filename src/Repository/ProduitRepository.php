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
}