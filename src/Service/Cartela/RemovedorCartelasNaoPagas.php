<?php

namespace App\Service\Cartela;

use App\Entity\Cartela\Cartela;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\EntityManagerInterface;

class RemovedorCartelasNaoPagas
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function execute(Collection $cartelas): void
    {
        foreach ($cartelas as $cartela) {
            if ($cartela->statusPagamento() === false){
                echo 1;
                $this->entityManager->remove($cartela);
                $this->entityManager->flush();
            }
        }
    }
}