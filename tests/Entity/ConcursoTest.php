<?php

use App\Entity\Cartela\Cartela;
use App\Entity\Concurso\Concurso;
use App\Entity\Concurso\EstadoConcurso\Aberto;
use PHPUnit\Framework\TestCase;

class ConcursoTest extends TestCase
{
    public function testConcursoAbertoDeveReceberCartelas()
    {
        $estadoConcurso = new Aberto();
        $concurso = new Concurso(
            'Concurso-teste',
            '12/08/2021',
            $estadoConcurso
        );

        $dezenas = [1,2,3,4,5,6,7,8,9,10];
        $cartela = new Cartela(
            'Renato',
            '21967218047',
            'renatoaugusto@ads.gmail.com',
            $dezenas
        );

        $concurso->addCartela($cartela);
        $cartelas = $concurso->getCartelas();

        self::assertCount(1, $cartelas);
    }
}