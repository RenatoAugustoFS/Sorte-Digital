<?php

namespace App\Service\EntityFactory;

use App\Entity\Concurso\Concurso;
use App\Entity\Concurso\EstadoConcurso\Aberto;
use App\Entity\Concurso\EstadoConcurso\EstadoConcurso;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;

class ConcursoFactory
{
    public function criarConcurso(Request $request): Concurso
    {
        $propriedades = $this->checarPropriedadesEnviadas($request);

        $descricao = $propriedades['descricao'];
        $dataInicio = $propriedades['dataInicio'];
        $quantidadeDezenasPorCartela = $propriedades['quantidadeDezenasPorCartela'];

        try {
            return new Concurso(
                $descricao,
                $dataInicio,
                $quantidadeDezenasPorCartela
            );
        } catch (\Exception $exception) {
            throw new \Exception($exception->getMessage());
        }
    }

    private function checarPropriedadesEnviadas(Request $request): array
    {
        if(!$request->request->get('descricao')) {
            throw new \DomainException(
                "Descrição do concurso deve ser preenchida!"
            );
        }

        if (!$request->request->get('dataInicio')) {
            throw new \DomainException(
                "Data de Inicio do concurso deve ser preenchida!"
            );
        }

        if (!$request->request->get('quantidadeDezenasPorCartela')) {
            throw new \DomainException(
                "Quantidade de dezenas que será permitido em cada cartela deste concurso deve ser especificada!"
            );
        }

        return [
            'dataInicio' =>  new \DateTimeImmutable($request->request->get('dataInicio')),
            'descricao' => $request->request->get('descricao'),
            'quantidadeDezenasPorCartela' => $request->get('quantidadeDezenasPorCartela')
        ];
    }

    private function estadoInicialConcurso(): EstadoConcurso
    {
        return new Aberto();
    }
}
