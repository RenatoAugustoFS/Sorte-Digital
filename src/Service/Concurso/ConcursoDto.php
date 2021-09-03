<?php

namespace App\Service\Concurso;

class ConcursoDto
{
    public string $descricao;
    public string $periodo;
    public string $restricaoDezenasPorCartela;

    public function __construct(string $descricao, string $periodo, string $restricaoDezenasPorCartela)
    {
        $this->descricao = $descricao;
        $this->periodo = $periodo;
        $this->restricaoDezenasPorCartela = $restricaoDezenasPorCartela;
    }
}