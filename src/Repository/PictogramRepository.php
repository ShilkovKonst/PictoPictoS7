<?php

namespace App\Repository;

use App\Entity\Pictogram;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;
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

    /**
     * @return Category[] Returns an array of Category objects
     */
    public function findAllWithPaginator(int $limit, int $page, string $sortBy, string $sortDir, string $filter, string $value): Paginator
    {
        if ($value == '' || $filter == '') {
            return new Paginator(
                $this->createQueryBuilder('p')
                    ->orderBy('p.' . $sortBy, $sortDir)
                    ->setFirstResult(($page - 1) * $limit)
                    ->setMaxResults($limit)
                    ->getQuery()
                    ->setHint(Paginator::HINT_ENABLE_DISTINCT, true),
                false
            );
        } else if ($filter == 'category') {
            return new Paginator(
                $this->createQueryBuilder('p')
                    ->leftJoin('p.category', 'c')
                    ->andWhere('c.title = :val')
                    ->setParameter('val', $value)
                    ->orderBy('p.' . $sortBy, $sortDir)
                    ->setFirstResult(($page - 1) * $limit)
                    ->setMaxResults($limit)
                    ->getQuery()
                    ->setHint(Paginator::HINT_ENABLE_DISTINCT, true),
                false
            );
        } else if ($filter == 'type') {
            return new Paginator(
                $this->createQueryBuilder('p')
                    ->andWhere('p.type = :val')
                    ->setParameter('val', $value)
                    ->orderBy('p.' . $sortBy, $sortDir)
                    ->setFirstResult(($page - 1) * $limit)
                    ->setMaxResults($limit)
                    ->getQuery()
                    ->setHint(Paginator::HINT_ENABLE_DISTINCT, true),
                false
            );
        }
    }

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
