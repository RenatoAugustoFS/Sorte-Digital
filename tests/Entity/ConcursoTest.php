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
    private string $dataInicioInvalida;

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

        $dataInicio = new DateTimeImmutable('now -1day');
        $this->dataInicioInvalida = $dataInicio->format('m/d/Y');
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

    public function testConcursoNaoDeveReceberCartelasComQuantidadeDezenasDiferenteDoPermitido()
    {
        self::expectException(DomainException::class);
        self::expectExceptionMessage("Este concurso só pode receber cartelas com 10 dezenas");

        $cartelaComNoveDezenas = new Cartela(
            'Renato',
            '123456789',
            'renatoaugusto@ads.gmail.com',
            [1,2,3,4,5,6,7,8,9]
        );
        $concursoComDezDezenas = new Concurso(
            'Concurso-Com-10-Dezenas',
            '12/12/2050',
            new Aberto(),
            10
        );

        $concursoComDezDezenas->addCartela($cartelaComNoveDezenas);
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


    public function testConcursoNaoPodeSerCriadoComDataDeInicioMenorQueADataAtual()
    {
        self::expectException(DomainException::class);
        self::expectExceptionMessage("Data enviada não pode ser anterior nem igual a hoje - 
                (Todo Concurso precisa de tempo desde a criação até seu início)");

        $estadoConcurso = new Aberto();
        $concurso = new Concurso(
            'Concurso-teste1',
            $this->dataInicioInvalida,
            $estadoConcurso,
            10
        );
    }

    public function testConcursoNaoPodeSerCriadoComDataEmFormatoInvalido()
    {
        self::expectException(InvalidArgumentException::class);
        self::expectExceptionMessage("Data enviada está num formato inválido");

        $estadoConcurso = new Aberto();
        $concurso = new Concurso(
            'Concurso-teste1',
            'data-inválida',
            $estadoConcurso,
            10
        );
    }

    /**DATA PROVIDERS*/
    public function concursoAberto()
    {
        $estadoConcurso = new Aberto();
        $concurso = new Concurso(
            'Concurso-teste',
            '12/30/2050',
            $estadoConcurso,
            10
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
            '12/30/2050',
            $estadoConcurso,
            10
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
            '12/30/2050',
            $estadoConcurso,
            10
        );

        return [
            'Concurso Fechado' => [$concurso],
        ];
    }

}