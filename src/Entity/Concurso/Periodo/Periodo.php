<?php

namespace App\Entity\Concurso\Periodo;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Embeddable
 */
class Periodo
{
    /**
     * @ORM\Column(type="datetime")
     */
    private \DateTimeInterface $dataAbertura;

    /**
     * @ORM\Column(type="datetime", nullable="true")
     */
    private \DateTimeInterface $dataEncerramento;

    public function __construct(\DateTimeInterface $dataAbertura, ?\DateTimeInterface $dataEncerramento = null)
    {
        $this->dataAbertura = $this->validarDataAbertura($dataAbertura);
    }

    public function encerra(): void
    {
        $this->dataEncerramento = new \DateTimeImmutable('now');
    }

    private function validarDataAbertura(\DateTimeInterface $dataAbertura): \DateTimeInterface
    {
        if ($dataAbertura < new \DateTimeImmutable('now')) {
            throw new \DomainException(
                "Data enviada não pode ser anterior nem igual a hoje - 
                (Todo Concurso precisa de tempo desde a criação até seu início)"
            );
        }
        return $dataAbertura;
    }

    public function dataAbertura(): string
    {
        return $this->dataAbertura->format('d/m/Y');
    }
}