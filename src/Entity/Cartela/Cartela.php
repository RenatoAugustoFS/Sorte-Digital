<?php

namespace App\Entity\Cartela;

use App\Entity\Concurso\Concurso;
use App\Repository\CartelaRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CartelaRepository::class)
 */
class Cartela
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
    private $nomeDoJogador;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $telefoneDoJogador;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $EmailDoJogador;

    /**
     * @ORM\Column(type="simple_array")
     */
    private $dezenas;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Concurso\Concurso", inversedBy="cartelas")
     */
    private $concurso;

    public function __construct($nomeDoJogador, $telefoneDoJogador, $EmailDoJogador,  array $dezenas)
    {
        $this->nomeDoJogador = $nomeDoJogador;
        $this->telefoneDoJogador = $telefoneDoJogador;
        $this->EmailDoJogador = $EmailDoJogador;
        $this->dezenas = $dezenas;
    }

    public function addConcurso(Concurso $concurso)
    {
        $this->concurso = $concurso;
    }

    public function dezenas(): ?array
    {
        return $this->dezenas;
    }

    public function nomeJogador():string
    {
        return $this->nomeDoJogador;
    }
}
