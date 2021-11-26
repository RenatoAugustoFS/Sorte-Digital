<?php

namespace App\Controller\Concurso;

use App\Repository\ConcursoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class AcompanhamentoConcurso extends AbstractController
{
    private ConcursoRepository $concursoRepository;

    public function __construct(ConcursoRepository $concursoRepository)
    {
        $this->concursoRepository = $concursoRepository;
    }

    public function handle(int $id): Response
    {
        $concurso = $this->concursoRepository->findOneBy(['id' => $id]);
        if (is_null($concurso)) {
            return new Response('', Response::HTTP_NOT_FOUND);
        }

        return $this
            ->render(
                '/concurso/acompanhamento-concurso.html.twig', [
                    'concurso' => $concurso,
                    'cartelas' => $concurso->cartelas(),
                    'sorteiosOficiais' => $concurso->sorteiosOficiais(),
                    'dezenasSorteadas' => $concurso->dezenasOficiaisSorteadas(),
                ]
            );
    }
}