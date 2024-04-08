<?php

namespace App\Repository;

use App\Entity\PictogramPronoun;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<PictogramPronom>
 *
 * @method PictogramPronom|null find($id, $lockMode = null, $lockVersion = null)
 * @method PictogramPronom|null findOneBy(array $criteria, array $orderBy = null)
 * @method PictogramPronom[]    findAll()
 * @method PictogramPronom[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PictogramPronounRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PictogramPronoun::class);
    }

    //    /**
    //     * @return PictogramPronom[] Returns an array of PictogramPronom objects
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

    //    public function findOneBySomeField($value): ?PictogramPronom
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
