<?php

namespace App\Entity\SorteioOficial;

use App\Entity\Concurso\Concurso;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\MappedSuperclass()
 * @ORM\DiscriminatorColumn(name="tipo", type="string")
 * @ORM\DiscriminatorMap({"quina" = "Quina", "megaSena" = "MegaSena"})
 */
abstract class SorteioOficial
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    protected $id;

    /** @ORM\Column(type="simple_array") */
    protected $dezenas;

    /** @ORM\Column(type="integer") */
    protected $numeroConcursoOficial;

    /** @ORM\ManyToOne(targetEntity="App\Entity\Concurso\Concurso", inversedBy="sorteiosOficiais") */
    protected $concurso;

    public function __construct(array $dezenas, int $numeroConcursoOficial)
    {
        $this->definirDezenas($dezenas);
        $this->numeroConcursoOficial = $numeroConcursoOficial;
    }

    public function addConcurso(Concurso $concurso)
    {
        $this->concurso = $concurso;
    }

    public function dezenas(): array
    {
        return $this->dezenas;
    }

    public function numeroConcursoOficial(): int
    {
        return $this->numeroConcursoOficial;
    }

    protected function definirDezenas(array $dezenas)
    {
        $dezenasLimpas = [];
        foreach ($dezenas as $dezena) {
            $dezenasLimpas[] = (int) $dezena;
        }
        $this->dezenas = $dezenasLimpas;
    }

    abstract protected function validarQuantidadeDezenas(array $dezenas);
}