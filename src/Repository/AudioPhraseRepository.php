<?php

namespace App\Repository;

use App\Entity\AudioPhrase;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<AudioPhrase>
 *
 * @method AudioPhrase|null find($id, $lockMode = null, $lockVersion = null)
 * @method AudioPhrase|null findOneBy(array $criteria, array $orderBy = null)
 * @method AudioPhrase[]    findAll()
 * @method AudioPhrase[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AudioPhraseRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AudioPhrase::class);
    }

    //    /**
    //     * @return AudioPhrase[] Returns an array of AudioPhrase objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('a')
    //            ->andWhere('a.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('a.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?AudioPhrase
    //    {
    //        return $this->createQueryBuilder('a')
    //            ->andWhere('a.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
