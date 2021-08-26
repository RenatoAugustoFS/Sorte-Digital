<?php

namespace App\Repository;

use App\Entity\Concurso\Concurso;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Concurso|null find($id, $lockMode = null, $lockVersion = null)
 * @method Concurso|null findOneBy(array $criteria, array $orderBy = null)
 * @method Concurso[]    findAll()
 * @method Concurso[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ConcursoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Concurso::class);
    }

    public function findConcursosAbertos()
    {
        $classe = Concurso::class;
        $dql = "SELECT c FROM $classe c WHERE c.estado = 'aberto'";

        $concursosAbertos = $this->getEntityManager()
            ->createQuery($dql)
            ->getResult();

        return $concursosAbertos;
    }

    public function findConcursosEmAndamento()
    {
        $classe = Concurso::class;
        $dql = "SELECT c FROM $classe c WHERE c.estado = 'emandamento'";

        $concursosAbertos = $this->getEntityManager()
            ->createQuery($dql)
            ->getResult();

        return $concursosAbertos;
    }

    public function findConcursosFechados()
    {
        $classe = Concurso::class;
        $dql = "SELECT c FROM $classe c WHERE c.estado = 'fechado'";

        $concursosAbertos = $this->getEntityManager()
            ->createQuery($dql)
            ->getResult();

        return $concursosAbertos;
    }
}
