<?php

namespace App\Controller\Concurso;

use App\Repository\ConcursoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class FormularioAdicionarCartela extends AbstractController
{
    private ConcursoRepository $concursoRepository;

    public function __construct(ConcursoRepository $concursoRepository)
    {
        $this->concursoRepository = $concursoRepository;
    }

    public function handle(int $id): Response
    {
        $concurso = $this->concursoRepository->find($id);

        return $this->render(
            '/concurso/formulario-criar-cartela.html.twig',
            ['idConcurso' => $id, 'dezenasPorCartela' => $concurso->dezenasPorCartela()]
        );
    }
}