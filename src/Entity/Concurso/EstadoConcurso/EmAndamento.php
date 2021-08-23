<?php

namespace App\Entity\Concurso\EstadoConcurso;

use App\Entity\Concurso\Concurso;
use Doctrine\ORM\Mapping as ORM;

class EmAndamento extends EstadoConcurso
{
    const ESTADO = 'emandamento';

    public function encerra(Concurso $concurso)
    {
        $concurso->estado = new Fechado();
    }

    public function podeReceberAposta(): bool
    {
        return false;
    }

    public function podeReceberSorteioOficial(): bool
    {
        return true;
    }

    public function __toString()
    {
        return self::ESTADO;
    }
}