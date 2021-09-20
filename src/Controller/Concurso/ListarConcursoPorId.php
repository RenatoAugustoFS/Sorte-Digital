<?php

namespace App\Controller\Concurso;

use App\Repository\ConcursoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class ListarConcursoPorId extends AbstractController
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

        $dezenasSorteadas = [];
        foreach ($concurso->sorteiosOficiais() as $sorteioOficial){
            foreach ($sorteioOficial->dezenas() as $dezena ) {
                $dezenasSorteadas[] = $dezena;
            }
        }

        return $this
            ->render(
                '/concurso/acompanhamento-concurso.twig', [
                    'concurso' => $concurso,
                    'cartelas' => $concurso->cartelas(),
                    'sorteiosOficiais' => $concurso->sorteiosOficiais(),
                    'dezenasSorteadas' => $dezenasSorteadas,
                ]
            );
    }
}