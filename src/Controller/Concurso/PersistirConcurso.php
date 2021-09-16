<?php

namespace App\Controller\Concurso;

use App\Service\Concurso\ConcursoDto;
use App\Service\Concurso\ConcursoFactory;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class PersistirConcurso extends AbstractController
{
    private ConcursoFactory $concursoFactory;
    private EntityManagerInterface $entityManager;

    public function __construct(ConcursoFactory $concursoFactory, EntityManagerInterface $entityManager)
    {
        $this->concursoFactory = $concursoFactory;
        $this->entityManager = $entityManager;
    }

    public function handle(Request $request): Response
    {
        $concursoDto = new ConcursoDto(
            $request->request->get('descricao'),
            $request->request->get('dataInicio'),
            $request->request->get('quantidadeDezenasPorCartela')
        );

        try {
            $concurso = $this->concursoFactory->criarConcurso($concursoDto);
            $this->entityManager->persist($concurso);
            $this->entityManager->flush();
        } catch (\Exception $exception) {
            $this->addFlash('notice', $exception->getMessage());
            return $this->redirectToRoute('formulario-concurso');
        }

        $this->addFlash('notice', 'Parabéns! Concurso Criado Com Sucesso!');
        return $this->redirectToRoute('home');
    }
}