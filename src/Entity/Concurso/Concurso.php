<?php

namespace App\Entity\Concurso;

use App\Entity\Cartela\Cartela;
use App\Entity\Concurso\Estado\Aberto;
use App\Entity\Concurso\Estado\EmAndamento;
use App\Entity\Concurso\Faturamento\Faturamento;
use App\Entity\Concurso\Periodo\Periodo;
use App\Entity\Concurso\Restricao\RestricaoDezenasPorCartela;
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

    /** @ORM\Embedded(class="App\Entity\Concurso\Periodo\Periodo") */
    private Periodo $periodo;

    /** @ORM\Embedded(class="App\Entity\Concurso\Restricao\RestricaoDezenasPorCartela") */
    private RestricaoDezenasPorCartela $restricao;

    /** @ORM\OneToMany(targetEntity="App\Entity\Cartela\Cartela", mappedBy="concurso", cascade={"remove", "persist"}) */
    private $cartelas;

    /** @ORM\OneToMany(targetEntity="App\Entity\SorteioOficial\SorteioOficial", mappedBy="concurso", cascade={"remove", "persist"}) */
    private $sorteiosOficiais;

    /** @ORM\OneToOne(targetEntity="App\Entity\Concurso\Faturamento\Faturamento", cascade={"persist", "remove"}) */
    private Faturamento $faturamento;

    public function __construct(
        string $descricao,
        Periodo $periodo,
        RestricaoDezenasPorCartela $restricao
    ) {
        $this->cartelas = new ArrayCollection();
        $this->sorteiosOficiais = new ArrayCollection();
        $this->estado = new Aberto();
        $this->faturamento = new Faturamento($this);
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

    public function addCartela(Cartela $cartela): void
    {
        $this->checarSeConcursoEstaAberto();
        $this->restricao->validarQuantidadeDezenasCartela($cartela);
        $this->cartelas->add($cartela);
        $cartela->addConcurso($this);
        $this->faturamento->atualizar();
    }

    private function checarSeConcursoEstaAberto()
    {
        if (!$this->estado instanceof Aberto) {
            throw new \DomainException(
                "Concurso com estado " . $this->estado . " não está aptos à adição de novas cartelas"
            );
        }
    }

    public function addSorteioOficial(SorteioOficial $sorteioOficial): void
    {
        $this->checarSeConcursoEstaEmAndamento();
        $this->checarSeSorteioOficialJaFoiAdd($sorteioOficial);
        $this->sorteiosOficiais->add($sorteioOficial);
        $sorteioOficial->addConcurso($this);
        $this->pontuaCartelas();
    }

    public function checarSeConcursoEstaEmAndamento(): void
    {
        if (!$this->estado instanceof EmAndamento) {
            throw new \DomainException(
                "Concurso com estado " . $this->estado . " não está aptos à apostas e sorteios"
            );
        }
    }

    private function checarSeSorteioOficialJaFoiAdd(SorteioOficial $sorteioOficial): void
    {
        if ($this->sorteiosOficiais->exists(function($key, $element) use ($sorteioOficial) {
            return $element->numeroConcursoOficial() === $sorteioOficial->numeroConcursoOficial();
        })) {
            throw new \DomainException("Este concurso já recebeu este sorteio oficial");
        }
    }

    public function pontuaCartelas(): void
    {
        foreach ($this->cartelas as $cartela) {
            $cartela->pontuar();
        }
    }

    public function dados(): array
    {
        return [
            'descricao' => $this->descricao,
            'dataAbertura' => $this->periodo->dataAbertura(),
            'estado' => $this->estado,
            'dezenasPermitidasPorCartela' => $this->restricao->dezenasPorCartela(),
            'valorArrecadado' => $this->faturamento->valorArrecadado(),
        ];
    }
}