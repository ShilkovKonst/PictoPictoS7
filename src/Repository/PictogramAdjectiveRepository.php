<?php

namespace App\Repository;

use App\Entity\PictogramAdjective;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<PictogramAdjective>
 *
 * @method PictogramAdjective|null find($id, $lockMode = null, $lockVersion = null)
 * @method PictogramAdjective|null findOneBy(array $criteria, array $orderBy = null)
 * @method PictogramAdjective[]    findAll()
 * @method PictogramAdjective[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PictogramAdjectiveRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PictogramAdjective::class);
    }

    //    /**
    //     * @return PictogramAdjective[] Returns an array of PictogramAdjective objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('p.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?PictogramAdjective
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
