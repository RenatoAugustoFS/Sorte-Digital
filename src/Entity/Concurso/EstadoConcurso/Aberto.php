<?php

namespace App\Entity\Concurso\EstadoConcurso;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class Aberto extends EstadoConcurso
{
    public function __construct()
    {
        parent::__construct('Aberto');
    }

    public function podeReceberAposta(): bool
    {
        return true;
    }
}