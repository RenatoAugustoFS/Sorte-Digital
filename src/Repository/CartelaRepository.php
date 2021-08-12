<?php

namespace App\Repository;

use App\Entity\Cartela\Cartela;
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
    //  * @return Cartela[] Returns an array of Cartela objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Cartela
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
