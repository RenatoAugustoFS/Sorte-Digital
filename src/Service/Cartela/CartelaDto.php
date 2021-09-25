<?php

namespace App\Service\Cartela;

class CartelaDto
{
    public $dezenas;
    public $nomeJogador;
    public $telefone;
    public $email;

    public function __construct($dezenas, $nomeJogador, $telefone, $email)
    {
        $this->dezenas = $dezenas;
        $this->nomeJogador = $nomeJogador;
        $this->telefone = $telefone;
        $this->email = $email;
    }
}