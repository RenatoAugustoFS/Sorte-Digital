<?php

namespace App\Entity\Concurso\EstadoConcurso;

use App\Entity\Concurso\Concurso;
use App\Repository\EstadoConcursoRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Embeddable
 */
abstract class EstadoConcurso
{
    /**
     * @ORM\Column(type="string", length=255)
     */
    private $descricao;

    public function __construct(string $descricao)
    {
        $this->descricao = $descricao;
    }

    public function inicia(Concurso $concurso)
    {
        throw new \DomainException("Este concurso não pode ser iniciado");
    }

    public function encerra(Concurso $concurso)
    {
        throw new \DomainException("Este concurso não pode ser encerrado");
    }

    public function descricao(): string
    {
        return $this->descricao;
    }

    public function __toString(): string
    {
        return $this->descricao;
    }

    abstract public function podeReceberAposta(): bool;
}

