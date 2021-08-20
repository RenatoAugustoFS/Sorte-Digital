<?php

namespace App\Entity\Concurso;

use App\Entity\Cartela\Cartela;
use App\Entity\Concurso\EstadoConcurso\Aberto;
use App\Entity\Concurso\EstadoConcurso\EstadoConcurso;
use App\Entity\Concurso\EstadoConcurso\Fechado;
use App\Entity\Concurso\Periodo\Periodo;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ConcursoRepository::class)
 */
class Concurso
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $descricao;

    /**
     * @ORM\Embedded(class="App\Entity\Concurso\EstadoConcurso\EstadoConcurso")
     */
    public EstadoConcurso $estado;

    /**
     * @ORM\Embedded(class="App\Entity\Concurso\Periodo\Periodo")
     */
    private Periodo $periodo;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Cartela\Cartela", mappedBy="concurso", cascade={"remove", "persist"})
     */
    private $cartelas;

    /**
     * @ORM\Column(type="integer")
     */
    private int $dezenasPermitidasPorCartela;

    public function __construct(
        string $descricao,
        Periodo $periodo,
        int $dezenasPermitidasPorCartela
    ) {
        $this->cartelas = new ArrayCollection();
        $this->descricao = $descricao;
        $this->periodo = $periodo;
        $this->estado = new Aberto();
        $this->validarQuantidadeDezenasPermitidasPorCartela($dezenasPermitidasPorCartela);
    }

    public function descricao(): string
    {
        return $this->descricao;
    }

    public function cartelas(): Collection
    {
        return $this->cartelas;
    }

    public function dataAbertura(): string
    {
        return $this->periodo->dataAbertura();
    }

    public function inicia(): void
    {
        $this->estado->inicia($this);
    }

    public function encerra(): void
    {
        $this->estado = new Fechado();
    }

    public function addCartela(Cartela $cartela): self
    {
        if (!$this->estado->podeReceberAposta()) {
            throw new \DomainException(
                "Concurso com estado ". $this->estado->descricao() ." não podem receber Cartelas"
            );
        }

        if(!$this->verificarQuantidadeDeDezenasCartela($cartela)){
            throw new \DomainException(
                "Este concurso só pode receber cartelas com {$this->dezenasPermitidasPorCartela} dezenas"
            );
        }

        $this->cartelas->add($cartela);
        $cartela->addConcurso($this);
        return $this;
    }

    private function verificarQuantidadeDeDezenasCartela(Cartela $cartela): bool
    {
        $quantidadeDezenas = count($cartela->dezenas());
        if ($quantidadeDezenas != $this->dezenasPermitidasPorCartela){
            return false;
        }
        return true;
    }

    private function validarQuantidadeDezenasPermitidasPorCartela(int $dezenasPermitidasPorCartela): void
    {
        if ($dezenasPermitidasPorCartela > 10 || $dezenasPermitidasPorCartela < 5) {
            throw new \DomainException("Quantidade de Dezenas permitidas por concurso deve ser > 5 OU < 10");
        }
        $this->dezenasPermitidasPorCartela = $dezenasPermitidasPorCartela;
    }

    public function getDezenasPermitidasPorCartela(): int
    {
        return $this->dezenasPermitidasPorCartela;
    }
}