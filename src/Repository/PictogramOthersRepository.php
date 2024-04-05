<?php

namespace App\Repository;

use App\Entity\PictogramOthers;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<PictogramOthers>
 *
 * @method PictogramOthers|null find($id, $lockMode = null, $lockVersion = null)
 * @method PictogramOthers|null findOneBy(array $criteria, array $orderBy = null)
 * @method PictogramOthers[]    findAll()
 * @method PictogramOthers[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PictogramOthersRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PictogramOthers::class);
    }

    //    /**
    //     * @return PictogramOthers[] Returns an array of PictogramOthers objects
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

    //    public function findOneBySomeField($value): ?PictogramOthers
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
