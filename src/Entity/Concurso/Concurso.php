<?php

namespace App\Entity\Concurso;

use App\Entity\Cartela\Cartela;
use App\Entity\Concurso\EstadoConcurso\Aberto;
use App\Entity\Concurso\EstadoConcurso\EstadoConcurso;
use App\Entity\Concurso\EstadoConcurso\Fechado;
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
     * @ORM\ManyToOne(targetEntity="App\Entity\Concurso\EstadoConcurso\EstadoConcurso")
     * @ORM\JoinColumn(nullable=false)
     */
    private EstadoConcurso $estado;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dataInicio;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $dataFim;

    /**
     * @ORM\Column(type="integer")
     */
    private int $dezenasPermitidasPorCartela;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Cartela\Cartela", mappedBy="concurso", cascade={"remove", "persist"})
     */
    private $cartelas;

    public function __construct(
        string $descricao,
        string $dataInicio,
        EstadoConcurso $estado,
        int $dezenasPermitidasPorCartela
    ) {
        $this->cartelas = new ArrayCollection();
        $this->descricao = $descricao;
        $this->dataInicio = $this->validarData($dataInicio);
        $this->estado = $estado;
        $this->validarQuantidadeDezenasPermitidasPorCartela($dezenasPermitidasPorCartela);
    }

    private function validarData(string $dataInicio)
    {
        try {
            $dataInicio = new \DateTimeImmutable($dataInicio);
        } catch (\Exception $exception) {
            throw new \InvalidArgumentException("Data enviada está num formato inválido");
        }

        if ($dataInicio < new \DateTimeImmutable('now')) {
            throw new \DomainException(
                "Data enviada não pode ser anterior nem igual a hoje - 
                (Todo Concurso precisa de tempo desde a criação até seu início)"
            );
        }

        return $dataInicio;
    }

    public function descricao(): string
    {
        return $this->descricao;
    }

    public function cartelas(): Collection
    {
        return $this->cartelas;
    }

    public function descricaoEstadoDoConcurso(): string
    {
        return $this->estado->descricao();
    }

    public function dataAbertura(): string
    {
        return $this->dataInicio->format('d/m/Y');
    }

    public function dezenasPermitidasPorCartela(): int
    {
        return $this->dezenasPermitidasPorCartela;
    }

    public function alteraEstado(EstadoConcurso $estadoConcurso): void
    {
        if ($this->estado instanceof Fechado) {
            throw new \DomainException("Concurso fechado não pode ter seu estado alterado");
        }

        if ($estadoConcurso instanceof Aberto){
            throw new \DomainException("Concurso não pode retroceder de estado para voltar a estar aberto");
        }

        $this->estado = $estadoConcurso;
    }

    public function addCartela(Cartela $cartela): self
    {
        if (!$this->podeReceberAposta()) {
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

    public function podeReceberAposta(): bool
    {
        return $this->estado->podeReceberAposta();
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
}
