<?php

namespace App\Entity\Concurso\EstadoConcurso;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Embeddable
 */
class Fechado extends EstadoConcurso
{
    public function __construct()
    {
        parent::__construct('Fechado');
    }

    public function podeReceberAposta(): bool
    {
        return false;
    }
}