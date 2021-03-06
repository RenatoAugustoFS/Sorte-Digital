<?php

namespace App\Entity\Concurso\Cartela;

use App\Entity\Concurso\Concurso;
use App\Entity\Concurso\Cartela\Jogador\Jogador;
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
     * @ORM\Embedded(class="App\Entity\Concurso\Cartela\Jogador\Jogador")
     */
    private Jogador $jogador;

    /**
     * @ORM\Column(type="simple_array")
     */
    private $dezenas;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Concurso\Concurso", inversedBy="cartelas")
     */
    private Concurso $concurso;

    /**
     * @ORM\Column(type="integer")
     */
    private $pontos;

    /**
     * @ORM\Column(type="boolean")
     */
    private $statusPagamento;


    public function __construct(array $dezenas, Jogador $jogador)
    {
        $this->dezenas = $dezenas;
        $this->jogador = $jogador;
        $this->pontos = 0;
        $this->statusPagamento = false;
    }

    public function token(): int
    {
        return $this->id;
    }

    public function addConcurso(Concurso $concurso)
    {
        $this->concurso = $concurso;
    }

    public function dezenas(): array
    {
        return $this->dezenas;
    }

    public function nomeJogador(): string
    {
        return $this->jogador->nome();
    }

    public function pagar(): void
    {
        $this->statusPagamento = true;
        $this->concurso->atualizarPremiacao();
    }

    public function statusPagamento(): bool
    {
        return $this->statusPagamento;
    }

    public function pontuar(): void
    {
        $dezenasPremiadas = array_intersect(
            $this->concurso->dezenasOficiaisSorteadas(),
            $this->dezenas()
        );
        $pontos = count($dezenasPremiadas);
        $this->pontos = $pontos;
    }

    public function pontos(): float
    {
        return $this->pontos;
    }

    public function telefoneJogador()
    {
        return $this->jogador->telefone();
    }
}
