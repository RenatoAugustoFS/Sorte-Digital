<?php

namespace App\Service\Concurso;

use App\Entity\Concurso\Concurso;

class ConcursoFactory
{
    public function criarConcurso(ConcursoDto $concursoDto): Concurso
    {
        $this->checarPropriedadesEnviadas($concursoDto);
        return new Concurso(
            $concursoDto->descricao,
            $concursoDto->periodo,
            $concursoDto->dezenasPorCartela
        );
    }

    private function checarPropriedadesEnviadas(ConcursoDto $concursoDto)
    {
        if(!$concursoDto->descricao) {
            throw new \DomainException("Descrição do concurso deve ser preenchida!");
        }

        if (!$concursoDto->periodo) {throw new \DomainException(
                "Data de Inicio do concurso deve ser preenchida!"
            );
        }

        if (!$concursoDto->dezenasPorCartela) {
            throw new \DomainException(
                "Quantidade de dezenas que será permitido em cada cartela deste concurso deve ser especificada!"
            );
        }
    }
}
