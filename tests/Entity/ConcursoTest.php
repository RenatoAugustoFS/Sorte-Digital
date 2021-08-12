<?php

use App\Entity\Cartela\Cartela;
use App\Entity\Concurso\Concurso;
use App\Entity\Concurso\EstadoConcurso\Aberto;
use App\Entity\Concurso\EstadoConcurso\EmAndamento;
use App\Entity\Concurso\EstadoConcurso\Fechado;
use PHPUnit\Framework\TestCase;

class ConcursoTest extends TestCase
{
    private Cartela $cartela;

    protected function setUp(): void
    {
        $dezenas = [1,2,3,4,5,6,7,8,9,10];
        $cartela = new Cartela(
            'Renato',
            '123456789',
            'renatoaugusto@ads.gmail.com',
            $dezenas
        );
        $this->cartela = $cartela;
    }

    /**
     * @dataProvider concursoAberto
     */
    public function testConcursoAbertoDeveReceberCartelas(Concurso $concurso)
    {
        $concurso->addCartela($this->cartela);
        $cartelas = $concurso->getCartelas();

        self::assertCount(1, $cartelas);
    }

    /**
     * @dataProvider concursoEmAndamento
     */
    public function testConcursoEmAndamentoNaoDeveReceberCartela(Concurso $concurso)
    {
        self::expectException(DomainException::class);
        self::expectExceptionMessage('Concurso com estado Em Andamento não podem receber Cartelas');

        $concurso->addCartela($this->cartela);
    }

    /**
     * @dataProvider concursoFechado
     */
    public function testConcursoFechadoNaoDeveReceberCartela(Concurso $concurso)
    {
        self::expectException(DomainException::class);
        self::expectExceptionMessage('Concurso com estado Fechado não podem receber Cartelas');

        $concurso->addCartela($this->cartela);
    }

    public function concursoAberto()
    {
        $estadoConcurso = new Aberto();
        $concurso = new Concurso(
            'Concurso-teste',
            '12/08/2021',
            $estadoConcurso
        );

        return [
            'Concurso Aberto' => [$concurso],
        ];
    }

    public function concursoEmAndamento()
    {
        $estadoConcurso = new EmAndamento();
        $concurso = new Concurso(
            'Concurso-teste',
            '12/08/2021',
            $estadoConcurso
        );

        return [
            'Concurso Em Andamento' => [$concurso],
        ];
    }

    public function concursoFechado()
    {
        $estadoConcurso = new Fechado();
        $concurso = new Concurso(
            'Concurso-teste',
            '12/08/2021',
            $estadoConcurso
        );

        return [
            'Concurso Fechado' => [$concurso],
        ];
    }

}