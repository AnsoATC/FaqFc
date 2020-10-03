<?php

namespace App\Repository;

use App\Entity\MessageTreeview;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method MessageTreeview|null find($id, $lockMode = null, $lockVersion = null)
 * @method MessageTreeview|null findOneBy(array $criteria, array $orderBy = null)
 * @method MessageTreeview[]    findAll()
 * @method MessageTreeview[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MessageTreeviewRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MessageTreeview::class);
    }

    // /**
    //  * @return MessageTreeview[] Returns an array of MessageTreeview objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('m.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?MessageTreeview
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
