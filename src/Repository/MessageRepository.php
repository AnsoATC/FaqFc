<?php

namespace App\Repository;

use App\Entity\FcCategory;
use App\Entity\Message;
use App\Entity\User;
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


    public function findResponsesOf($message): ?array
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.id IN (:ids)')
            ->setParameter('ids', $message->getResponses())
            ->orderBy('m.id', 'ASC')
            //->setMaxResults(20)
            ->getQuery()
            ->getResult();
    }


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


    public function findCountTotalMessageOf(User $user)
    {
        return $this->createQueryBuilder('m')
            ->select('count(m.id)')
            ->andWhere('m.user = :user')
            ->setParameter('user', $user)
            ->getQuery()
            ->getSingleScalarResult();
    }

    public function findCountTotalNonRepliedMessage()
    {
        return $this->createQueryBuilder('m')
            ->select('count(m.id)')
            ->andWhere('m.responses = :null')->setParameter('null', serialize(null)) //not null
            ->orWhere('m.responses = :empty')->setParameter('empty', serialize([])) //n
            ->andWhere('m.isResponse  = :isResponse')
            //This is set to null to filter only new message posted as question 
            ->setParameter('isResponse', false)
            ->getQuery()
            ->getSingleScalarResult();
    }

    public function findNonRepliedMessages(): ?array
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.responses = :null')->setParameter('null', serialize(null)) //not null
            ->orWhere('m.responses = :empty')->setParameter('empty', serialize([])) //n
            ->andWhere('m.isResponse  = :isResponse')
            //This is set to null to filter only new message posted as question 
            ->setParameter('isResponse', false)
            ->getQuery()
            ->getResult();
    }



    //Get  messages of a category
    public function findLastMessageOfCategory($category): ?array
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.category  = :category')
            ->setParameter('category', $category)
            ->andWhere('m.isResponse  = :isResponse')
            //This is set to null to filter only new message posted as question 
            ->setParameter('isResponse', false)
            ->orderBy('m.id', 'ASC')
            ->setMaxResults(100)
            ->getQuery()
            ->getResult();
    }

    //Get list of user who has posted at least one message
    public function findParticipantsOfCategory(FcCategory $category): ?array
    {
        return $this->createQueryBuilder('m')
            ->select('m.user')
            ->andWhere('m.category  = :category')
            ->setParameter('category', $category)
            ->orderBy('m.id', 'DESC')
            //->setMaxResults(100)
            ->getQuery()
            ->getResult();
    }
}
