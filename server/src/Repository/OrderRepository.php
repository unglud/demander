<?php

namespace App\Repository;

use App\Entity\Order;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Order|null find($id, $lockMode = null, $lockVersion = null)
 * @method Order|null findOneBy(array $criteria, array $orderBy = null)
 * @method Order[]    findAll()
 * @method Order[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OrderRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Order::class);
    }

     /**
      * @return ArrayCollection Returns an array of Order objects
      */

    public function findUnfinishedIncomingOrdersFor($id)
    {
        $result =  $this->createQueryBuilder('o')
            ->andWhere('o.end_location = :id')
            ->andWhere('o.end_date > :today')
            ->setParameter('id', $id)
            ->setParameter('today', new \DateTime())
            ->orderBy('o.end_date', 'ASC')
            ->getQuery()
            ->getResult()
        ;

        return $result;
    }


    /*
    public function findOneBySomeField($value): ?Order
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
