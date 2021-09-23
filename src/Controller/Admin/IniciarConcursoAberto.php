<?php

namespace App\Controller\Admin;

use App\Repository\ConcursoRepository;
use App\Service\Cartela\RemovedorCartelasNaoPagas;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class IniciarConcursoAberto extends AbstractController
{
    private ConcursoRepository $concursoRepository;
    private EntityManagerInterface $entityManager;
    private RemovedorCartelasNaoPagas $removedorCartelasNaoPagas;

    public function __construct(
        ConcursoRepository $concursoRepository,
        EntityManagerInterface $entityManager,
        RemovedorCartelasNaoPagas $removedorCartelasNaoPagas
    ) {

        $this->concursoRepository = $concursoRepository;
        $this->entityManager = $entityManager;
        $this->removedorCartelasNaoPagas = $removedorCartelasNaoPagas;
    }

    public function handle(Request $request): Response
    {
        $this->entityManager->beginTransaction();

        $concursosAbertos = $this->concursoRepository->findConcursosAbertos();
        foreach ($concursosAbertos as $concurso) {
            $dataAbertura = $concurso->dataAbertura();
            $dataAtual = new \DateTime();
            if ($dataAtual->format('d/m/Y') === $dataAbertura){
                $concurso->inicia();
                $this->removedorCartelasNaoPagas->execute($concurso->cartelas());
                $this->entityManager->persist($concurso);
            }
        }
        $this->entityManager->flush();
        $this->entityManager->commit();
    }
}