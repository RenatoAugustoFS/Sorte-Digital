<?php

namespace App\Entity\Concurso\Estado;

use App\Entity\Concurso\Concurso;
use Doctrine\ORM\Mapping as ORM;

class EmAndamento extends EstadoConcurso
{
    const ESTADO = 'Em Andamento';

    public function encerra(Concurso $concurso)
    {
        $concurso->estado = new Fechado();
    }

    public function __toString()
    {
        return 'Em Andamento';
    }
}