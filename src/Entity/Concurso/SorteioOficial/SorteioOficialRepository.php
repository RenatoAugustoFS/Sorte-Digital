<?php

namespace App\Entity\Concurso\SorteioOficial;

interface SorteioOficialRepository
{
    public function buscarResultadoOficialQuina(): Quina;
    public function buscarResultadoOficialMegaSena(): MegaSena;
}