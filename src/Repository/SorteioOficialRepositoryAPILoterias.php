<?php

namespace App\Repository;

use App\Entity\Concurso\SorteioOficial\MegaSena;
use App\Entity\Concurso\SorteioOficial\Quina;
use App\Entity\Concurso\SorteioOficial\SorteioOficialRepository;

class SorteioOficialRepositoryAPILoterias implements SorteioOficialRepository
{
    const URL_QUINA = "http://apiloterias.com.br/app/resultado?loteria=quina&token=79wY8WeG0ajGwl5";
    const URL_MEGASENA = "http://apiloterias.com.br/app/resultado?loteria=megasena&token=79wY8WeG0ajGwl5";

    public function buscarResultadoOficialQuina(): Quina
    {
        $respostaApi = file_get_contents(self::URL_QUINA);
        $respostaApi = json_decode($respostaApi, true);
        $this->checarErroNaRespostaRequisicao($respostaApi);
        return new Quina(
            $respostaApi['dezenas'],
            $respostaApi['numero_concurso'],
            new \DateTimeImmutable($respostaApi['data_concurso'])
        );
    }

    public function buscarResultadoOficialMegaSena(): MegaSena
    {
        $respostaApi = file_get_contents(self::URL_MEGASENA);
        $respostaApi = json_decode($respostaApi, true);
        $this->checarErroNaRespostaRequisicao($respostaApi);
        return new MegaSena(
            $respostaApi['dezenas'],
            $respostaApi['numero_concurso'],
            new \DateTimeImmutable($respostaApi['data_concurso'])
        );
    }

    private function checarErroNaRespostaRequisicao($respostaApi) {
        if (array_key_exists('erro', $respostaApi)) {
            throw new \Exception($respostaApi['erro']);
        }
    }
}