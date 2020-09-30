<?php

namespace App\Repository;

use App\Entity\FcCategory;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method FcCategory|null find($id, $lockMode = null, $lockVersion = null)
 * @method FcCategory|null findOneBy(array $criteria, array $orderBy = null)
 * @method FcCategory[]    findAll()
 * @method FcCategory[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FcCategoryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, FcCategory::class);
    }

    // /**
    //  * @return FcCategory[] Returns an array of FcCategory objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('f.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?FcCategory
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
