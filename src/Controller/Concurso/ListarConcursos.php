<?php

namespace App\Controller\Concurso;

use App\Repository\ConcursoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ListarConcursos extends AbstractController
{
    private ConcursoRepository $concursoRepository;

    public function __construct(ConcursoRepository $concursoRepository)
    {
        $this->concursoRepository = $concursoRepository;
    }

    public function handle(Request $request): Response
    {
        $concursosAbertos = $this->concursoRepository->findConcursosAbertos();
        $concursosEmAndamento = $this->concursoRepository->findConcursosEmAndamento();
        $concursosFechados = $this->concursoRepository->findConcursosFechados();

        return $this->render('/concurso/index.html.twig', [
            'h1_name' => 'Página inicial',
            'concursosAbertos' => $concursosAbertos,
            'concursosEmAndamento' => $concursosEmAndamento,
            'concursosFechados' => $concursosFechados,
        ]);
    }
}