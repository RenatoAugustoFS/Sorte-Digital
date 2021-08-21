<?php

namespace App\Entity\Concurso\EstadoConcurso;

use App\Entity\Concurso\Concurso;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Embeddable
 */
class EstadoConcurso
{
    /**
     * @ORM\Column(type="string", length=255)
     */
    protected $descricao;

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
}

