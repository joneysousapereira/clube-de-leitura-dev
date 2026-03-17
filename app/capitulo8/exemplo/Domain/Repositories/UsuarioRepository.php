<?php

declare(strict_types=1);

namespace App\Domain\Repositories;

use App\Domain\Entities\Usuario;

interface UsuarioRepository
{
    public function salvar(Usuario $usuario): void;
}
