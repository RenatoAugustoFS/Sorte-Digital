<?php

namespace App\Entity\Jogador;

use App\Entity\ValueObject\Email;
use App\Entity\ValueObject\Telefone;
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
     * @ORM\Embedded(class="App\Entity\ValueObject\Telefone")
     */
    private Telefone $telefone;

    /**
     * @ORM\Embedded(class="App\Entity\ValueObject\Email")
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
}