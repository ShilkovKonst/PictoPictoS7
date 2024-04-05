<?php

namespace App\Repository;

use App\Entity\PictogramVerbe;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<PictogramVerbe>
 *
 * @method PictogramVerbe|null find($id, $lockMode = null, $lockVersion = null)
 * @method PictogramVerbe|null findOneBy(array $criteria, array $orderBy = null)
 * @method PictogramVerbe[]    findAll()
 * @method PictogramVerbe[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PictogramVerbeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PictogramVerbe::class);
    }

    //    /**
    //     * @return PictogramVerbe[] Returns an array of PictogramVerbe objects
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

    //    public function findOneBySomeField($value): ?PictogramVerbe
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
