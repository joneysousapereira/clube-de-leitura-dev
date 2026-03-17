<?php

declare(strict_types=1);

namespace App\Application\DTO;

class CriarUsuarioDTO
{
    public function __construct(
        public string $nome,
        public string $email
    ) {}
}
