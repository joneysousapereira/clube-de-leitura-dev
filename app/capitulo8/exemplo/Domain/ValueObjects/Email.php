<?php

declare(strict_types=1);

namespace App\Domain\ValueObjects;

use InvalidArgumentException;

class Email
{
    private string $valor;

    public function __construct(string $email)
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidArgumentException("Email inválido");
        }

        $this->valor = $email;
    }

    public function valor(): string
    {
        return $this->valor;
    }
}
