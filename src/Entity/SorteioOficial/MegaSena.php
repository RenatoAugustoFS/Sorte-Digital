<?php

namespace App\Entity\SorteioOficial;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class MegaSena extends SorteioOficial
{
    public function __construct(array $dezenas, int $numeroConcursoOficial)
    {
        $this->validarDezenas($dezenas);
        parent::__construct($dezenas, $numeroConcursoOficial);
    }

    protected function validarDezenas(array $dezenas)
    {
        if (count($dezenas) != 6){
            throw new \DomainException("Mega Sena só pode ter 6 dezenas por sorteio");
        }
    }
}