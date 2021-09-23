<?php

namespace App\Service\Cartela;

class CartelaDto
{
    public array $dezenas;
    public string $nomeJogador;
    public string $telefone;
    public string $email;

    public function __construct($dezenas, $nomeJogador, $telefone, $email)
    {
        $this->dezenas = $dezenas;
        $this->nomeJogador = $nomeJogador;
        $this->telefone = $telefone;
        $this->email = $email;
    }
}