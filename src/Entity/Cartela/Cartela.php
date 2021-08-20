<?php

namespace App\Entity\Cartela;

use App\Entity\Cartela\Jogador\Jogador;
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
     * @ORM\Embedded(class="App\Entity\Cartela\Jogador\Jogador")
     */
    private Jogador $jogador;

    /**
     * @ORM\Column(type="simple_array")
     */
    private $dezenas;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Concurso\Concurso", inversedBy="cartelas")
     */
    private $concurso;

    public function __construct(array $dezenas, Jogador $jogador)
    {
        $this->dezenas = $dezenas;
        $this->jogador = $jogador;
    }

    public function addConcurso(Concurso $concurso)
    {
        $this->concurso = $concurso;
    }

    public function dezenas(): ?array
    {
        return $this->dezenas;
    }

    public function nomeJogador()
    {
        return $this->jogador->nome();
    }
}
