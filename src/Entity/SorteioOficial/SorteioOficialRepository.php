<?php

namespace App\Entity\SorteioOficial;

interface SorteioOficialRepository
{
    public function buscarResultadoOficialQuina(): Quina;
    public function buscarResultadoOficialMegaSena(): MegaSena;
}