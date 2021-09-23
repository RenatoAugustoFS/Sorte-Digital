<?php

namespace App\Service\Cartela;

use App\Entity\Concurso\Cartela\Cartela;
use App\Entity\Concurso\Cartela\Jogador\Email\Email;
use App\Entity\Concurso\Cartela\Jogador\Jogador;
use App\Entity\Concurso\Cartela\Jogador\Telefone\Telefone;

class CartelaFactory
{
    public function criar(CartelaDto $cartelaDto): Cartela
    {
        $this->checarPropriedadesEnviadas($cartelaDto);

        return new Cartela(
            $cartelaDto->dezenas,
            new Jogador(
                $cartelaDto->nomeJogador,
                new Telefone($cartelaDto->telefone),
                new Email($cartelaDto->email)
            ));
    }

    private function checarPropriedadesEnviadas(CartelaDto $cartelaDto)
    {
        if(!$cartelaDto->dezenas) {
            throw new \DomainException("dezenas não podem ser vazias");
        }

        if (!$cartelaDto->nomeJogador) {throw new \DomainException(
            "nome do jogador deve ser preenchido"
        );
        }

        if (!$cartelaDto->telefone) {
            throw new \DomainException(
                "telefone deve ser especificado!"
            );
        }

        if (!$cartelaDto->email) {
            throw new \DomainException(
                "email deve ser especificado!"
            );
        }
    }
}