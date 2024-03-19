<?php

namespace App\Repository;

use App\Entity\Pictogram;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Pictogram>
 *
 * @method Pictogram|null find($id, $lockMode = null, $lockVersion = null)
 * @method Pictogram|null findOneBy(array $criteria, array $orderBy = null)
 * @method Pictogram[]    findAll()
 * @method Pictogram[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PictogramRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Pictogram::class);
    }

    //    /**
    //     * @return Pictogram[] Returns an array of Pictogram objects
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

    //    public function findOneBySomeField($value): ?Pictogram
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
