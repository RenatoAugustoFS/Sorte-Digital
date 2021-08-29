<?php

namespace App\Service\buscadorSorteioOficial;

use App\Service\SorteioOficialFactory\ResultadoOficialFactory;

class BuscadorSorteioOficialAPILoterias implements BuscadorSorteioOficialInterface
{
    const URL_QUINA = "http://apiloterias.com.br/app/resultado?loteria=quina&token=FgO3B0vZhR4pIag";
    const URL_MEGASENA = "http://apiloterias.com.br/app/resultado?loteria=megasena&token=FgO3B0vZhR4pIag";

    private $resultadoOficialFactory;

    public function __construct(ResultadoOficialFactory $resultadoOficialFactory)
    {
        $this->resultadoOficialFactory = $resultadoOficialFactory;
    }

    public function buscarResultadoOficialQuina()
    {
        $retorno = file_get_contents(self::URL_QUINA);
        $retorno = json_decode($retorno);
        $this->checarErroNoRetornoRequisicao($retorno);
        return $this->resultadoOficialFactory->criarQuina($retorno);
    }

    public function buscarResultadoOficialMegaSena()
    {
        $retorno = file_get_contents(self::URL_MEGASENA);
        $retorno = json_decode($retorno);
        $this->checarErroNoRetornoRequisicao($retorno);
        return $this->resultadoOficialFactory->criarMegaSena($retorno);

    }

    private function checarErroNoRetornoRequisicao($retorno) {
        if (property_exists($retorno, 'erro')) {
            throw new \Exception($retorno->erro);
        }
    }
}