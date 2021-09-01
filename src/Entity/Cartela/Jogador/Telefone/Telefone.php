<?php

namespace App\Entity\Cartela\Jogador\Telefone;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Embeddable
 */
class Telefone
{
    /**
     * @ORM\Column(type="string")
     */
    private string $numero;

    public function __construct(string $numero)
    {
        if (!$this->validarNumero($numero)){
            throw new \InvalidArgumentException("Número de telefone inválido");
        }

        $this->numero = $numero;
    }

    private function validarNumero($numero): bool
    {
        return preg_match(
            '/^(?:(?:\+|00)?(55)\s?)?(?:\(?([1-9][0-9])\)?\s?)?(?:((?:9\d|[2-9])\d{3})\-?(\d{4}))$/',
            $numero
        );
    }
    
    
}