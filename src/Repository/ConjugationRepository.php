<?php

namespace App\Repository;

use App\Entity\Conjugation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Conjugation>
 *
 * @method Conjugation|null find($id, $lockMode = null, $lockVersion = null)
 * @method Conjugation|null findOneBy(array $criteria, array $orderBy = null)
 * @method Conjugation[]    findAll()
 * @method Conjugation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ConjugationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Conjugation::class);
    }

    //    /**
    //     * @return Conjugation[] Returns an array of Conjugation objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('c.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Conjugation
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
