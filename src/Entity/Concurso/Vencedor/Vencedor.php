<?php

namespace App\Entity\Concurso\Vencedor;

use App\Entity\Concurso\Cartela\Cartela;
use App\Entity\Concurso\Concurso;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 */
class Vencedor
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Concurso\Concurso", inversedBy="vencedores")
     */
    private Concurso $concurso;

    /**
     * @ORM\Column(type="float", nullable=false)
     */
    private float $premio;

    /** @ORM\OneToOne(targetEntity="App\Entity\Concurso\Cartela\Cartela") */
    private Cartela $cartela;

    public function __construct(float $premio, Cartela $cartela)
    {
        $this->premio = $premio;
        $this->cartela = $cartela;
    }

    public function addConcurso(Concurso $concurso): void
    {
        $this->concurso = $concurso;
    }

    public function __toString(): string
    {
        return $this->cartela->nomeJogador() . ' / '  . $this->cartela->telefoneJogador();
    }
}