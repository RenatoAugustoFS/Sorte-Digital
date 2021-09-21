<?php

namespace App\Controller\Concurso;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class FormularioAdicionarCartela extends AbstractController
{
    public function handle(int $id): Response
    {
        return $this->render(
            '/concurso/formulario-criar-cartela.html.twig',
            ['idConcurso' => $id],
        );
    }
}