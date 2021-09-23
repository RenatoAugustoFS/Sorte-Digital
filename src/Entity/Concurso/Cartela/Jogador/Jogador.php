<?php

namespace App\Entity\Concurso\Cartela\Jogador;

use App\Entity\Concurso\Cartela\Jogador\Email\Email;
use App\Entity\Concurso\Cartela\Jogador\Telefone\Telefone;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Embeddable
 */
class Jogador
{
    /**
     * @ORM\Column(type="string")
     */
    private string $nome;

    /**
     * @ORM\Embedded(class="App\Entity\Concurso\Cartela\Jogador\Telefone\Telefone")
     */
    private Telefone $telefone;

    /**
     * @ORM\Embedded(class="App\Entity\Concurso\Cartela\Jogador\Email\Email")
     */
    private Email $email;

    public function __construct(string $nome, Telefone $telefone, Email $email)
    {
        $this->nome = $nome;
        $this->telefone = $telefone;
        $this->email = $email;
    }

    public function nome(): string
    {
        return $this->nome;
    }

    public function telefone(): string
    {
        return $this->telefone->numero();
    }
}