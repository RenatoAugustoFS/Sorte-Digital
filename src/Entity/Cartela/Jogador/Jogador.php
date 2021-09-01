<?php

namespace App\Entity\Cartela\Jogador;

use App\Entity\Cartela\Jogador\Email\Email;
use App\Entity\Cartela\Jogador\Telefone\Telefone;
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
     * @ORM\Embedded(class="App\Entity\Cartela\Jogador\Telefone\Telefone")
     */
    private Telefone $telefone;

    /**
     * @ORM\Embedded(class="App\Entity\Cartela\Jogador\Email\Email")
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