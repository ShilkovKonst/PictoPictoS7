<?php

namespace App\Repository;

use App\Entity\Irregular;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Irregular>
 *
 * @method Irregular|null find($id, $lockMode = null, $lockVersion = null)
 * @method Irregular|null findOneBy(array $criteria, array $orderBy = null)
 * @method Irregular[]    findAll()
 * @method Irregular[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class IrregularRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Irregular::class);
    }

    //    /**
    //     * @return Irregular[] Returns an array of Irregular objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('i')
    //            ->andWhere('i.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('i.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Irregular
    //    {
    //        return $this->createQueryBuilder('i')
    //            ->andWhere('i.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
