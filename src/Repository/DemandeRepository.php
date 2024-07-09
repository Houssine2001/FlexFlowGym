<?php

namespace App\Repository;

use App\Entity\Demande;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Demande>
 *
 * @method Demande|null find($id, $lockMode = null, $lockVersion = null)
 * @method Demande|null findOneBy(array $criteria, array $orderBy = null)
 * @method Demande[]    findAll()
 * @method Demande[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DemandeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Demande::class);
    }

    public function findOffresLesPlusDemandees($limit = null)
    {
        return $this->createQueryBuilder('d')
            ->select('d.offre, COUNT(d.offre) as nombre_demandes')
            ->groupBy('d.offre')
            ->orderBy('nombre_demandes', 'DESC')
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult();
    }



    // Dans votre DemandeRepository

public function countByOffre(): array
{
    return $this->createQueryBuilder('d')
        ->select('COUNT(d.id) AS nombre_demandes, o.nom AS offre_nom')
        ->leftJoin('d.offre', 'o')
        ->groupBy('o.nom')
        ->getQuery()
        ->getResult();
}

//    /**
//     * @return Demande[] Returns an array of Demande objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('d')
//            ->andWhere('d.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('d.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Demande
//    {
//        return $this->createQueryBuilder('d')
//            ->andWhere('d.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
