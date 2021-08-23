<?php

namespace App\Entity\Concurso\EstadoConcurso;

use App\Entity\Concurso\Concurso;
use Doctrine\ORM\Mapping as ORM;

abstract class EstadoConcurso
{
    public function inicia(Concurso $concurso)
    {
        throw new \DomainException("Este concurso não pode ser iniciado");
    }

    public function encerra(Concurso $concurso)
    {
        throw new \DomainException("Este concurso não pode ser encerrado");
    }

    abstract public function podeReceberAposta();
    abstract public function podeReceberSorteioOficial();
}

