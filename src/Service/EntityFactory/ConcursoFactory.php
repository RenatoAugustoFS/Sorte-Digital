<?php

namespace App\Service\EntityFactory;

use App\Entity\Concurso\Concurso;
use App\Entity\Concurso\EstadoConcurso\EstadoConcurso;
use App\Repository\EstadoConcursoRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;

class ConcursoFactory
{
    private EstadoConcursoRepository $estadoConcursoRepository;

    public function __construct(EstadoConcursoRepository $estadoConcursoRepository)
    {
        $this->estadoConcursoRepository = $estadoConcursoRepository;
    }

    public function criarConcurso(Request $request): Concurso
    {
        $propriedades = $this->checarPropriedadesEnviadas($request);

        $dataInicioEnviada = $propriedades['dataInicio'];
        $descricao = $propriedades['descricao'];
        $estadoConcurso = $this->estadoInicialConcurso();

        try {
            return new Concurso($descricao, $dataInicioEnviada, $estadoConcurso);
        } catch (\InvalidArgumentException $exception) {
            throw new \InvalidArgumentException($exception->getMessage());
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
        return [
            'dataInicio' =>  $request->request->get('dataInicio'),
            'descricao' => $request->request->get('descricao'),
        ];
    }

    private function estadoInicialConcurso(): EstadoConcurso
    {
        return $this->estadoConcursoRepository->findOneBy([
            'descricao' => 'aberto',
        ]);
    }
}
