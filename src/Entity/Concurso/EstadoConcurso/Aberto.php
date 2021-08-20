<?php

namespace App\Entity\Concurso\EstadoConcurso;

use App\Entity\Concurso\Concurso;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Embeddable
 */
class Aberto extends EstadoConcurso
{
    public function __construct()
    {
        parent::__construct('Aberto');
    }

    public function inicia(Concurso $concurso)
    {
        $concurso->estado = new EmAndamento();
    }

    public function podeReceberAposta(): bool
    {
        return true;
    }
}