<?php

namespace App\Entity\ValueObject;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Embeddable
 */
class Email
{
    /**
     * @ORM\Column(type="string")
     */
    private string $email;

    public function __construct(string $email)
    {
        $this->validarEmail($email);
        $this->email = $email;
    }

    private function validarEmail($email): bool
    {
        if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
            throw new \InvalidArgumentException("Email inválido");
        }

        return true;
    }
}