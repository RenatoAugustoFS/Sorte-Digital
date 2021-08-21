<?php

namespace App\Entity\Concurso\RestricaoConcurso;

use App\Entity\Cartela\Cartela;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Embeddable
 */
class RestricaoDezenasPorCartela
{
    /**
     * @ORM\Column(type="integer")
     */
    private int $dezenasPorCartela;

    public function __construct(int $dezenasPorCartela)
    {
        $this->dezenasPorCartela = $this->validarDezenasPermitidasPorCartela($dezenasPorCartela);
    }

    private function validarDezenasPermitidasPorCartela(int $dezenasPorCartela): int
    {
        if ($dezenasPorCartela > 10 || $dezenasPorCartela < 5) {
            throw new \DomainException("Quantidade de Dezenas permitidas por concurso deve ser > 5 OU < 10");
        }

        return $dezenasPorCartela;
    }

    public function validarQuantidadeDezenasCartela(Cartela $cartela)
    {
        $quantidadeDezenas = count($cartela->dezenas());
        if ($quantidadeDezenas != $this->dezenasPorCartela){
            throw new \DomainException(
                "Este concurso só pode receber cartelas com {$this->dezenasPorCartela()} dezenas"
            );
        }
    }

    public function dezenasPorCartela(): int
    {
        return $this->dezenasPorCartela;
    }
}