<?php

namespace App\Entity\Concurso\Vencedor;

use App\Entity\Cartela\Cartela;
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

    /** @ORM\OneToOne(targetEntity="App\Entity\Cartela\Cartela") */
    private Cartela $cartela;

    public function __construct(Concurso $concurso, float $premio, Cartela $cartela)
    {
        $this->concurso = $concurso;
        $this->premio = $premio;
        $this->cartela = $cartela;
    }
}