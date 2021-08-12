<?php

namespace App\Controller\Concurso;

use App\Service\EntityFactory\ConcursoFactory;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ConcursoController extends AbstractController
{
    private ConcursoFactory $concursoFactory;
    private EntityManagerInterface $entityManager;

    public function __construct(
        ConcursoFactory $concursoFactory,
        EntityManagerInterface $entityManager
    ) {
        $this->concursoFactory = $concursoFactory;
        $this->entityManager = $entityManager;
    }

    public function formularioCriarConcurso(Request $request): Response
    {
        return $this
            ->render(
                '/concursos/formulario-inserir-concurso.html.twig'
            );
    }

    public function criarNovoConcurso(Request $request): Response
    {
        try {
            $concurso = $this->concursoFactory->criarConcurso($request);
            $this->entityManager->persist($concurso);
            $this->entityManager->flush();
        } catch (\InvalidArgumentException $exception) {
            $this->addFlash('notice', $exception->getMessage());
            return $this->redirectToRoute('formulario-concurso');
        }

        $this->addFlash('notice', 'Parabén! Concurso Criado Com Sucesso!');
        return $this->redirectToRoute('formulario-concurso');
    }
}