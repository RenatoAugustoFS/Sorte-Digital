<?php

namespace App\Entity\Concurso\EstadoConcurso;

use App\Entity\Concurso\Concurso;
use Doctrine\ORM\Mapping as ORM;

class Aberto extends EstadoConcurso
{
    const ESTADO = 'aberto';

    public function inicia(Concurso $concurso)
    {
        $concurso->estado = new EmAndamento();
    }

    public function podeReceberAposta(): bool
    {
        return true;
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