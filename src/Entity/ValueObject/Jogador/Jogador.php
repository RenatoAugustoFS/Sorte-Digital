<?php

namespace App\Entity\ValueObject\Jogador;

use App\Entity\ValueObject\Email\Email;
use App\Entity\ValueObject\Telefone\Telefone;
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
     * @ORM\Embedded(class="App\Entity\ValueObject\Telefone\Telefone")
     */
    private Telefone $telefone;

    /**
     * @ORM\Embedded(class="App\Entity\ValueObject\Email\Email")
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