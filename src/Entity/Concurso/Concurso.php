<?php

namespace App\Entity\Concurso;

use App\Entity\Cartela\Cartela;
use App\Entity\Concurso\EstadoConcurso\Aberto;
use App\Entity\Concurso\EstadoConcurso\EstadoConcurso;
use App\Entity\Concurso\EstadoConcurso\EstadoConcursoType;
use App\Entity\Concurso\PeriodoConcurso\Periodo;
use App\Entity\Concurso\RestricaoConcurso\RestricaoDezenasPorCartela;
use App\Entity\SorteioOficial\SorteioOficial;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/** @ORM\Entity(repositoryClass=ConcursoRepository::class) */
class Concurso
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private int $id;

    /** @ORM\Column(type="string", length=255) */
    private string $descricao;

    /** @ORM\Column(type="enumestadoconcurso") */
    public $estado;

    /** @ORM\Embedded(class="App\Entity\Concurso\PeriodoConcurso\Periodo") */
    private Periodo $periodo;

    /** @ORM\Embedded(class="App\Entity\Concurso\RestricaoConcurso\RestricaoDezenasPorCartela") */
    private RestricaoDezenasPorCartela $restricao;

    /** @ORM\OneToMany(targetEntity="App\Entity\Cartela\Cartela", mappedBy="concurso", cascade={"remove", "persist"}) */
    private $cartelas;

    /** @ORM\OneToMany(targetEntity="App\Entity\SorteioOficial\SorteioOficial", mappedBy="concurso", cascade={"remove", "persist"}) */
    private $sorteiosOficiais;

    public function __construct(
        string $descricao,
        Periodo $periodo,
        RestricaoDezenasPorCartela $restricao
    ) {
        $this->cartelas = new ArrayCollection();
        $this->sorteiosOficiais = new ArrayCollection();
        $this->estado = new Aberto();
        $this->descricao = $descricao;
        $this->periodo = $periodo;
        $this->restricao = $restricao;
    }

    public function cartelas(): Collection
    {
        return $this->cartelas;
    }

    public function sorteiosOficiais(): Collection
    {
        return $this->sorteiosOficiais;
    }

    public function inicia(): void
    {
        $this->estado->inicia($this);
    }

    public function encerra(): void
    {
        $this->estado->encerra($this);
    }

    public function addCartela(Cartela $cartela): self
    {
        if (!$this->estado->podeReceberAposta()) {
            throw new \DomainException(
                "Concurso com estado ". $this->estado ." não podem receber Cartelas"
            );
        }
        $this->restricao->validarQuantidadeDezenasCartela($cartela);

        $this->cartelas->add($cartela);
        $cartela->addConcurso($this);
        return $this;
    }

    public function addSorteioOficial(SorteioOficial $sorteioOficial): self
    {
        if (!$this->estado->podeReceberSorteioOficial()) {
            throw new \DomainException(
                "Concurso com estado ". $this->estado ." não podem receber SorteiosOficiais"
            );
        }
        $this->sorteiosOficiais->add($sorteioOficial);
        $sorteioOficial->addConcurso($this);
        return $this;
    }

    public function dados(): array
    {
        return [
            'descricao' => $this->descricao,
            'dataAbertura' => $this->periodo->dataAbertura(),
            'estado' => $this->estado,
            'dezenasPermitidasPorCartela' => $this->restricao->dezenasPorCartela(),
        ];
    }
}