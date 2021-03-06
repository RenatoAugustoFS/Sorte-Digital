<?php

namespace App\Entity\Concurso\Premiacao;

use App\Entity\Concurso\Concurso;
use App\Entity\Concurso\Vencedor\Vencedor;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PremiacaoRepository::class)
 */
class Premiacao
{
    const PORCENTAGEM_GANHADOR = 80;
    const PORCENTAGEM_BANCA = 20;

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity=Concurso::class, inversedBy="premiacao")
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

        $this->valorArrecadado = $quantidadeCartelasPagas * $this->concurso->valorCota();
        $this->premioMaisPontos = ($this->valorArrecadado / 100) * self::PORCENTAGEM_GANHADOR;
        $this->arrecadacaoBanca = ($this->valorArrecadado / 100) * self::PORCENTAGEM_BANCA;
    }

    public function premioMaisPontos(): float
    {
        return $this->premioMaisPontos;
    }

    public function premia(Collection $cartelasVencedoras): void
    {
        $premioDividido = $this->caulcarPremioDividido($cartelasVencedoras);
        foreach ($cartelasVencedoras as $cartela){
            $this->concurso->addVencedor(new Vencedor($premioDividido, $cartela));
        }
    }

    private function caulcarPremioDividido($cartelasVencedoras): float
    {
        $this->premioPorGanhador = ($this->premioMaisPontos / $cartelasVencedoras->count());
        return $this->premioPorGanhador;
    }
}
