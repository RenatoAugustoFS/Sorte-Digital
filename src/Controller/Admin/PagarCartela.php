<?php

namespace App\Controller\Admin;

use App\Repository\CartelaRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class PagarCartela extends AbstractController
{
    private EntityManagerInterface $entityManager;
    private CartelaRepository $cartelaRepository;

    public function __construct(EntityManagerInterface $entityManager, CartelaRepository $cartelaRepository)
    {
        $this->entityManager = $entityManager;
        $this->cartelaRepository = $cartelaRepository;
    }

    public function handle(int $id): Response
    {
        $cartela = $this->cartelaRepository->find($id);
        $cartela->pagar();
        $this->entityManager->flush();
        return $this->redirectToRoute('home');
    }
}