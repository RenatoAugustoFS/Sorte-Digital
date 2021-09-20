<?php

namespace App\Entity\Concurso;

use App\Entity\Cartela\Cartela;
use App\Entity\Concurso\Estado\Aberto;
use App\Entity\Concurso\Estado\EmAndamento;
use App\Entity\Concurso\Premiacao\Premiacao;
use App\Entity\Concurso\Periodo\Periodo;
use App\Entity\Concurso\QuantidadeDezenasPorCartela\QuantidadeDezenasPorCartela;
use App\Entity\Concurso\Vencedor\Vencedor;
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

    /** @ORM\Embedded(class="App\Entity\Concurso\QuantidadeDezenasPorCartela\QuantidadeDezenasPorCartela") */
    private QuantidadeDezenasPorCartela $quantidadeDezenasPorCartela;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Cartela\Cartela", mappedBy="concurso", cascade={"remove", "persist"})
     * @ORM\OrderBy({"pontos" = "DESC"})
     */
    private $cartelas;

    /** @ORM\ManyToMany(targetEntity="App\Entity\SorteioOficial\SorteioOficial", mappedBy="concursos", cascade={"remove", "persist"}) */
    private $sorteiosOficiais;

    /** @ORM\OneToOne(targetEntity="App\Entity\Concurso\Premiacao\Premiacao", cascade={"persist", "remove"}) */
    private Premiacao $premiacao;

    /** @ORM\OneToMany(targetEntity="App\Entity\Concurso\Vencedor\Vencedor", mappedBy="concurso", cascade={"remove", "persist"}) */
    private $vencedores;

    public function __construct(
        string $descricao,
        Periodo $periodo,
        QuantidadeDezenasPorCartela $quantidadeDezenasPorCartela
    ) {
        $this->descricao = $descricao;
        $this->periodo = $periodo;
        $this->quantidadeDezenasPorCartela = $quantidadeDezenasPorCartela;
        $this->estado = new Aberto();
        $this->cartelas = new ArrayCollection();
        $this->sorteiosOficiais = new ArrayCollection();
        $this->premiacao = new Premiacao($this);
        $this->vencedores = new ArrayCollection();
    }

    public function id(): int
    {
        return $this->id;
    }

    public function dataAbertura(): string
    {
        return $this->periodo->dataAbertura();
    }

    public function cartelas(): Collection
    {
        return $this->cartelas;
    }

    public function valorCota(): float
    {
        return 10;
    }

    public function cartelasPagas(): Collection
    {
        $cartelasPagas = $this->cartelas->filter(function($cartela) {
            return $cartela->statusPagamento() === true;
        });

        return $cartelasPagas;
    }

    public function dezenasPorCartela(): int
    {
        return $this->quantidadeDezenasPorCartela->dezenasPorCartela();
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
        $this->periodo->encerra();
    }

    public function addCartela(Cartela $cartela): void
    {
        $this->checarSeConcursoEstaAberto();
        $this->quantidadeDezenasPorCartela->validarQuantidadeDezenasCartela($cartela);
        $this->cartelas->add($cartela);
        $cartela->addConcurso($this);
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
        if($this->checarSesorteioOficialJaFoiAdd($sorteioOficial)){return;}
        $this->sorteiosOficiais->add($sorteioOficial);
        $sorteioOficial->addConcurso($this);
        $this->pontuaCartelas();
        $this->verificarSeHouveVencedores();
    }

    public function checarSeConcursoEstaEmAndamento(): void
    {
        if (!$this->estado instanceof EmAndamento) {
            throw new \DomainException(
                "Concurso com estado " . $this->estado . " não está aptos à apostas e sorteios"
            );
        }
    }

    public function pontuaCartelas(): void
    {
        foreach ($this->cartelas as $cartela) {
            $cartela->pontuar();
        }
    }

    public function dezenasOficiaisSorteadas(): array
    {
        $dezenasSorteadas = [];
        $sorteiosOficiais = $this->sorteiosOficiais()->toArray();
        foreach ($sorteiosOficiais as $sorteioOficial) {
            $dezenasSorteadas = array_unique(
                array_merge($dezenasSorteadas, $sorteioOficial->dezenas())
            );
        }
        return $dezenasSorteadas;
    }

    private function checarSesorteioOficialJaFoiAdd(SorteioOficial $sorteioOficial): bool
    {
        if ($this->sorteiosOficiais->exists(function($key, $element) use ($sorteioOficial) {
            return $element->numeroConcursoOficial() === $sorteioOficial->numeroConcursoOficial();
        })) {
            return true;
        }
        return false;
    }

    private function verificarSeHouveVencedores()
    {
        $cartelasVencedoras = $this->cartelas->filter(function($cartela) {
            return $cartela->pontos() == $this->quantidadeDezenasPorCartela->dezenasPorCartela();
        });

        if ($cartelasVencedoras->count() > 0){
            $this->encerra();
            $this->premiacao->premia($cartelasVencedoras);
        }
    }

    public function atualizarPremiacao(): void
    {
        $this->premiacao->atualizarArrecadacao();
    }

    public function addVencedor(Vencedor $vencedor): void
    {
        $this->vencedores->add($vencedor);
        $vencedor->addConcurso($this);
    }

    public function vencedores(): Collection
    {
        return $this->vencedores;
    }

    public function premiacaoMaisPontos(): float
    {
        return $this->premiacao->premioMaisPontos();
    }
}