<?php

namespace App\Repository;

use App\Entity\Avis;
use App\Entity\Produit;
use App\Entity\Utilisateur;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

// Repository Avis : permet d'effectuer des requêtes sur la table des avis
class AvisRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Avis::class);
    }

    /** @return Avis[] */
    public function findByProduit(Produit $produit): array
    {
        return $this->createQueryBuilder('a')
            ->where('a.produit = :produit')
            ->setParameter('produit', $produit)
            ->orderBy('a.createdAt', 'DESC')
            ->getQuery()
            ->getResult();
    }

    public function findNoteMoyenne(Produit $produit): ?float
    {
        $result = $this->createQueryBuilder('a')
            ->select('AVG(a.note) as moyenne')
            ->where('a.produit = :produit')
            ->setParameter('produit', $produit)
            ->getQuery()
            ->getSingleScalarResult();

        return $result !== null ? round((float) $result, 1) : null;
    }

    public function findOneByUserAndProduit(Utilisateur $user, Produit $produit): ?Avis
    {
        return $this->findOneBy(['utilisateur' => $user, 'produit' => $produit]);
    }

    /** Retourne un tableau [produitId => noteMoyenne] pour une liste de produits (une seule requête). */
    public function findNotesMoyennes(array $produits): array
    {
        if (empty($produits)) {
            return [];
        }

        $rows = $this->createQueryBuilder('a')
            ->select('IDENTITY(a.produit) as produit_id, AVG(a.note) as moyenne')
            ->where('a.produit IN (:produits)')
            ->setParameter('produits', $produits)
            ->groupBy('a.produit')
            ->getQuery()
            ->getResult();

        $map = [];
        foreach ($rows as $row) {
            $map[(int) $row['produit_id']] = round((float) $row['moyenne'], 1);
        }

        return $map;
    }
}
