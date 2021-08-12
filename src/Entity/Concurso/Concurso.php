<?php

namespace App\Entity\Concurso;

use App\Entity\Cartela\Cartela;
use App\Entity\Concurso\EstadoConcurso\EstadoConcurso;
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
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $descricao;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Concurso\EstadoConcurso\EstadoConcurso")
     * @ORM\JoinColumn(nullable=false)
     */
    public EstadoConcurso $estado;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dataInicio;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $dataFim;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Cartela\Cartela", mappedBy="concurso", cascade={"remove", "persist"})
     */
    private $cartelas;

    public function __construct(string $descricao, string $dataInicio, EstadoConcurso $estado)
    {
        $this->cartelas = new ArrayCollection();
        $this->descricao = $descricao;
        $this->dataInicio = $this->validarData($dataInicio);
        $this->estado = $estado;
    }

    private function validarData(string $data)
    {
        try {
            return new \DateTimeImmutable($data);
        } catch (\Exception $exception) {
            throw new \InvalidArgumentException("Data enviada está num formato inválido");
        }
    }

    public function getDescricao(): string
    {
        return $this->descricao;
    }

    public function addCartela(Cartela $cartela): self
    {
        if ($this->verificarSeConcursoPodeReceberAposta() == false) {
            throw new \DomainException(
                "Concurso com estado ". $this->estado->descricao() ." não podem receber Cartelas"
            );
        }

        $this->cartelas->add($cartela);
        $cartela->addConcurso($this);
        return $this;
    }

    public function getCartelas(): Collection
    {
        return $this->cartelas;
    }

    private function verificarSeConcursoPodeReceberAposta(): bool
    {
        return $this->estado->podeReceberAposta();
    }
}
