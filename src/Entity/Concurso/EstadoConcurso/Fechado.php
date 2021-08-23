<?php

namespace App\Entity\Concurso\EstadoConcurso;

use Doctrine\ORM\Mapping as ORM;

class Fechado extends EstadoConcurso
{
    const ESTADO = 'fechado';

    public function podeReceberAposta(): bool
    {
        return false;
    }

    public function podeReceberSorteioOficial(): bool
    {
        return false;
    }

    public function __toString()
    {
        return self::ESTADO;
    }
}