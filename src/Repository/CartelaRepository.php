<?php

namespace App\Repository;

use App\Entity\Concurso\Cartela\Cartela;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Cartela|null find($id, $lockMode = null, $lockVersion = null)
 * @method Cartela|null findOneBy(array $criteria, array $orderBy = null)
 * @method Cartela[]    findAll()
 * @method Cartela[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CartelaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Cartela::class);
    }

    // /**
    //  * @return A[] Returns an array of A objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?A
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
