<?php

namespace App\Entity\Concurso\Estado;

use Doctrine\ORM\Mapping as ORM;

class Fechado extends EstadoConcurso
{
    const ESTADO = 'Fechado';

    public function __toString()
    {
        return 'Fechado';
    }
}