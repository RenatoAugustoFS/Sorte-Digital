<?php

namespace App\Entity\Concurso\Faturamento;

use App\Entity\Concurso\Concurso;
use App\Repository\FaturamentoRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=FaturamentoRepository::class)
 */
class Faturamento
{
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
     * @ORM\Column(type="integer", nullable=false)
     */
    private int $valorArrecadado;

    public function __construct(Concurso $concurso)
    {
        $this->concurso = $concurso;
        $this->valorArrecadado = 0;
    }

    public function atualizar(): void
    {
        $quantidadeCartelas = $this->concurso
            ->cartelas()
            ->count();

        $this->valorArrecadado = $quantidadeCartelas * $this->concurso->cota();
    }

    public function valorArrecadado(): int
    {
        return $this->valorArrecadado;
    }
}
