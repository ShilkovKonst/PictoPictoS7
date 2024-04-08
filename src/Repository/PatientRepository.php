<?php

namespace App\Repository;

use App\Entity\Patient;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Patient>
 *
 * @method Patient|null find($id, $lockMode = null, $lockVersion = null)
 * @method Patient|null findOneBy(array $criteria, array $orderBy = null)
 * @method Patient[]    findAll()
 * @method Patient[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PatientRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Patient::class);
    }

    //    /**
    //     * @return Patient[] Returns an array of Patient objects
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
    public function findAllWithPaginator(int $limit, int $page, string $sortBy, string $sortDir): Paginator
    {
        return new Paginator(
            $this->createQueryBuilder('p')
                ->orderBy('p.' . $sortBy, $sortDir)
                ->setFirstResult(($page - 1) * $limit)
                ->setMaxResults($limit)
                ->getQuery()
                ->setHint(Paginator::HINT_ENABLE_DISTINCT, true),
            false
        );
    }

    /**
     * @return Category[] Returns an array of Category objects
     */
    public function findbyTherapistWithPaginator(int $therapistId, int $limit, int $page, string $sortBy, string $sortDir): Paginator
    {
        return new Paginator(
            $this->createQueryBuilder('p')
            ->andWhere('p.therapist = :therapistId')
            ->setParameter('therapistId', $therapistId)
                ->orderBy('p.' . $sortBy, $sortDir)
                ->setFirstResult(($page - 1) * $limit)
                ->setMaxResults($limit)
                ->getQuery()
                ->setHint(Paginator::HINT_ENABLE_DISTINCT, true),
            false
        );
    }

    // public function findOneBySomeField($value): ?Patient
    // {
    //     return $this->createQueryBuilder('p')
    //         ->andWhere('p.exampleField = :val')
    //         ->setParameter('val', $value)
    //         ->getQuery()
    //         ->getOneOrNullResult();
    // }

    public function findOneByName($firstName, $lastName): ?Patient
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.firstName = :firstName', 'p.lastName = :lastName')
            ->setParameter('firstName', $firstName)
            ->setParameter('lastName', $lastName)
            ->getQuery()
            ->getOneOrNullResult();
    }
}
