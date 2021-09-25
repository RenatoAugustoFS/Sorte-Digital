<?php

namespace App\Entity\Concurso\Estado;

use App\Entity\Concurso\Concurso;
use Doctrine\ORM\Mapping as ORM;

class Aberto extends EstadoConcurso
{
    const ESTADO = 'Aberto';

    public function inicia(Concurso $concurso)
    {
        $concurso->estado = new EmAndamento();
    }

    public function __toString()
    {
        return 'Aberto';
    }
}