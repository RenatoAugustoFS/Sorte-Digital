<?php

namespace App\Entity\Concurso\EstadoConcurso;

use App\Repository\EstadoConcursoRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\InheritanceType("SINGLE_TABLE")
 */
abstract class EstadoConcurso
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

    public function __construct(string $descricao)
    {
        $this->descricao = $descricao;
    }

    public function descricao(): string
    {
        return $this->descricao;
    }

    abstract public function podeReceberAposta(): bool;
}

