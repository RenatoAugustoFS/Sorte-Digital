<?php

namespace App\Entity\Concurso\EstadoConcurso;

use App\Entity\Concurso\Concurso;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Embeddable
 */
class EmAndamento extends EstadoConcurso
{
    public function __construct()
    {
        parent::__construct('Em Andamento');
    }

    public function encerra(Concurso $concurso)
    {
        $concurso->estado = new Fechado();
    }

    public function podeReceberAposta(): bool
    {
        return false;
    }
}