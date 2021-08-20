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
    /*
    public function findConcursosAbertos()
    {
        $classe = Concurso::class;
        $dql = "SELECT concurso, estado FROM $classe concurso 
                JOIN concurso.estado estado 
                WITH estado.descricao = 'Aberto'";

        $concursosAbertos = $this->getEntityManager()
            ->createQuery($dql)
            ->getResult();

        return $concursosAbertos;
    }

    public function findConcursosEmAndamento()
    {
        $classe = Concurso::class;
        $dql = "SELECT concurso, estado FROM $classe concurso 
                JOIN concurso.estado estado 
                WITH estado.descricao = 'Em Andamento'";

        $concursosAbertos = $this->getEntityManager()
            ->createQuery($dql)
            ->getResult();

        return $concursosAbertos;
    }

    public function findConcursosFechados()
    {
        $classe = Concurso::class;
        $dql = "SELECT concurso, estado FROM $classe concurso 
                JOIN concurso.estado estado 
                WITH estado.descricao = 'Fechado'";

        $concursosAbertos = $this->getEntityManager()
            ->createQuery($dql)
            ->getResult();

        return $concursosAbertos;
    }
    */
}
