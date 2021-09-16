<?php

namespace App\Controller\Concurso;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class FormularioCriarConcurso extends AbstractController
{
    public function handle(Request $request): Response
    {
        return $this
            ->render(
                '/concursos/formulario-inserir-concurso.html.twig'
            );
    }
}