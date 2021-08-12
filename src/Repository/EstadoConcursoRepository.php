<?php

namespace App\Repository;

use App\Entity\Concurso\EstadoConcurso\EstadoConcurso;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method EstadoConcurso|null find($id, $lockMode = null, $lockVersion = null)
 * @method EstadoConcurso|null findOneBy(array $criteria, array $orderBy = null)
 * @method EstadoConcurso[]    findAll()
 * @method EstadoConcurso[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EstadoConcursoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EstadoConcurso::class);
    }

    // /**
    //  * @return EstadoConcurso[] Returns an array of EstadoConcurso objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('e.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?EstadoConcurso
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
