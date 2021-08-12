<?php

namespace App\Entity\Concurso\EstadoConcurso;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class EmAndamento extends EstadoConcurso
{
    public function __construct()
    {
        parent::__construct('Em Andamento');
    }

    public function podeReceberAposta(): bool
    {
        return false;
    }
}