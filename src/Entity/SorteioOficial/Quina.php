<?php

namespace App\Entity\SorteioOficial;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class Quina extends SorteioOficial
{
    public function __construct(array $dezenas, int $numeroConcursoOficial)
    {
        $this->validarDezenas($dezenas);
        parent::__construct($dezenas, $numeroConcursoOficial);
    }

    protected function validarDezenas(array $dezenas)
    {
        if (count($dezenas) != 5){
            throw new \DomainException("Quina só pode ter 5 dezenas por sorteio");
        }
    }
}