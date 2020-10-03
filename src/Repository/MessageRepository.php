<?php

namespace App\Repository;

use App\Entity\Message;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Message|null find($id, $lockMode = null, $lockVersion = null)
 * @method Message|null findOneBy(array $criteria, array $orderBy = null)
 * @method Message[]    findAll()
 * @method Message[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MessageRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Message::class);
    }

    // /**
    //  * @return Message[] Returns an array of Message objects
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
    public function findOneBySomeField($value): ?Message
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;

        
        //return null;
        // return $this->createQueryBuilder('m')
        //     ->andWhere('m.id IN (:ids)')
        //     ->setParameter('ids', $category)
        //     ->orderBy('m.id', 'DESC')
        //     ->setMaxResults(20)
        //     ->getQuery()
        //     ->getResult();
    }
    */

    public function search($question): ?array
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.content  LIKE :content')
            ->setParameter('content', '%' . $question . '%')
            ->orWhere('m.title  LIKE :title')
            ->setParameter('title', '%' . $question . '%')
            ->orderBy('m.id', 'ASC')
            ->setMaxResults(100)
            ->getQuery()
            ->getResult();
    }


    public function findCountTotal()
    {
        return $this->createQueryBuilder('m')
            ->select('count(m.id)')
            ->getQuery()
            ->getSingleScalarResult();
    }

    //Get  messages of a category
    public function findLastMessageOfCategory($category): ?array
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.category  = :category')
            ->setParameter('category', $category)
            ->orderBy('m.id', 'DESC')
            ->setMaxResults(100)
            ->getQuery()
            ->getResult();
    }
}
