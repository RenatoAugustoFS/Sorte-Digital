<?php

namespace App\Service\SorteioOficialFactory;

use App\Entity\SorteioOficial\MegaSena;
use App\Entity\SorteioOficial\Quina;

class ResultadoOficialFactory
{
    public function criarQuina(object $propriedades)
    {
        $this->checarPropriedadesEnviadas($propriedades);
        return new Quina(
            $propriedades->dezenas,
            $propriedades->numero_concurso
        );
    }

    public function criarMegaSena(object $propriedades)
    {
        $this->checarPropriedadesEnviadas($propriedades);
        return new MegaSena(
            $propriedades->dezenas,
            $propriedades->numero_concurso
        );
    }

    private function checarPropriedadesEnviadas(object $propriedades)
    {
        if (!$propriedades->dezenas){
            throw new \DomainException(
                "Dezenas do Concurso Oficial não está preenchida"
            );
        }
        if (!$propriedades->numero_concurso){
            throw new \DomainException(
                "Numero do Concurso Oficial não está preenchido"
            );
        }
    }
}