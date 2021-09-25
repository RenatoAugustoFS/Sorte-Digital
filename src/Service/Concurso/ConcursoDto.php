<?php

namespace App\Service\Concurso;

class ConcursoDto
{
    public string $descricao;
    public string $periodo;
    public string $dezenasPorCartela;

    public function __construct(string $descricao, string $periodo, string $dezenasPorCartela)
    {
        $this->descricao = $descricao;
        $this->periodo = $periodo;
        $this->dezenasPorCartela = $dezenasPorCartela;
    }
}