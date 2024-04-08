<?php

namespace App\Repository;

use App\Entity\PictogramNoun;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<PictogramNom>
 *
 * @method PictogramNom|null find($id, $lockMode = null, $lockVersion = null)
 * @method PictogramNom|null findOneBy(array $criteria, array $orderBy = null)
 * @method PictogramNom[]    findAll()
 * @method PictogramNom[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PictogramNounRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PictogramNoun::class);
    }

    //    /**
    //     * @return PictogramNom[] Returns an array of PictogramNom objects
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

    //    public function findOneBySomeField($value): ?PictogramNom
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
