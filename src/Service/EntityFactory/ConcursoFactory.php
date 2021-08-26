<?php

namespace App\Service\EntityFactory;

use App\Entity\Concurso\Concurso;
use App\Entity\Concurso\PeriodoConcurso\Periodo;
use App\Entity\Concurso\RestricaoConcurso\RestricaoDezenasPorCartela;
use Symfony\Component\HttpFoundation\Request;

class ConcursoFactory
{
    public function criarConcurso(Request $request): Concurso
    {
        $this->checarPropriedadesEnviadas($request);

        $descricao = $request->request->get('descricao');
        $periodo = new Periodo(
            new \DateTimeImmutable(
                $request->request->get('dataInicio')
            )
        );
        $restricaoDezenas = new RestricaoDezenasPorCartela(
            $request
                ->request->get('quantidadeDezenasPorCartela')
        );

        return new Concurso($descricao, $periodo, $restricaoDezenas);
    }

    private function checarPropriedadesEnviadas(Request $request): bool
    {
        if(!$request->request->has('descricao')) {
            throw new \DomainException(
                "Descrição do concurso deve ser preenchida!"
            );
        }
        if (!$request->request->has('dataInicio')) {
            throw new \DomainException(
                "Data de Inicio do concurso deve ser preenchida!"
            );
        }
        if (!$request->request->has('quantidadeDezenasPorCartela')) {
            throw new \DomainException(
                "Quantidade de dezenas que será permitido em cada cartela deste concurso deve ser especificada!"
            );
        }
        return true;
    }
}
