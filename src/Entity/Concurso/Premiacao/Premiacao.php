<?php

namespace App\Entity\Concurso\Premiacao;

use App\Entity\Concurso\Concurso;
use App\Repository\PremiacaoRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PremiacaoRepository::class)
 */
class Premiacao
{
    const PORCENTAGEM_GANHADOR = 80;
    const PORCENTAGEM_BANCA = 20;
    const VALOR_CARTELA = 10;

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity=Concurso::class)
     */
    private Concurso $concurso;

    /**
     * @ORM\Column(type="float", nullable=false)
     */
    private float $valorArrecadado;

    /**
     * @ORM\Column(type="float", nullable=false)
     */
    private float $premioMaisPontos;

    /**
     * @ORM\Column(type="float", nullable=false)
     */
    private float $arrecadacaoBanca;

    public function __construct(Concurso $concurso)
    {
        $this->concurso = $concurso;
        $this->valorArrecadado = 0;
        $this->premioMaisPontos = 0;
        $this->arrecadacaoBanca = 0;
    }

    public function atualizarArrecadacao(): void
    {
        $cartelasPagas = $this->concurso->cartelasPagas();
        $quantidadeCartelasPagas = $cartelasPagas->count();

        $this->valorArrecadado = $quantidadeCartelasPagas * self::VALOR_CARTELA;
        $this->premioMaisPontos = ($this->valorArrecadado / 100) * self::PORCENTAGEM_GANHADOR;
        $this->arrecadacaoBanca = ($this->valorArrecadado / 100) * self::PORCENTAGEM_BANCA;
    }

    public function valorArrecadado(): float
    {
        return $this->valorArrecadado;
    }
}
