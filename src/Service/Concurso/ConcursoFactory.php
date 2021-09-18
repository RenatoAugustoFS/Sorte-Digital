<?php

namespace App\Service\Concurso;

use App\Entity\Concurso\Concurso;
use App\Entity\Concurso\Periodo\Periodo;
use App\Entity\Concurso\QuantidadeDezenasPorCartela\QuantidadeDezenasPorCartela;
use App\Entity\Concurso\Restricao\RestricaoDezenasPorCartela;

class ConcursoFactory
{
    public function criarConcurso(ConcursoDto $concursoDto): Concurso
    {
        $this->checarPropriedadesEnviadas($concursoDto);
        $descricao = $concursoDto->descricao;
        $periodo = new Periodo(new \DateTimeImmutable($concursoDto->periodo));
        $dezenasPorCartela = new QuantidadeDezenasPorCartela($concursoDto->restricaoDezenasPorCartela);

        return new Concurso($descricao, $periodo, $dezenasPorCartela);
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

        if (!$concursoDto->restricaoDezenasPorCartela) {
            throw new \DomainException(
                "Quantidade de dezenas que será permitido em cada cartela deste concurso deve ser especificada!"
            );
        }
    }
}
