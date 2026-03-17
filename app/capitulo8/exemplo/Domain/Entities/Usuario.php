<?php

declare(strict_types=1);

namespace App\Domain\Entities;

use App\Domain\ValueObjects\Email;

class Usuario
{
    private int $id;

    public function __construct(
        private string $nome,
        private Email $email
    ) {}

    public function nome(): string
    {
        return $this->nome;
    }

    public function email(): Email
    {
        return $this->email;
    }

    public function id(): int
    {
        return $this->id;
    }
}
