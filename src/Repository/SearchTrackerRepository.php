<?php

namespace App\Repository;

use App\Entity\SearchTracker;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method SearchTracker|null find($id, $lockMode = null, $lockVersion = null)
 * @method SearchTracker|null findOneBy(array $criteria, array $orderBy = null)
 * @method SearchTracker[]    findAll()
 * @method SearchTracker[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SearchTrackerRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SearchTracker::class);
    }

    // /**
    //  * @return SearchTracker[] Returns an array of SearchTracker objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?SearchTracker
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
