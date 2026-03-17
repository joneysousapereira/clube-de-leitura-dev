<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence;

use App\Domain\Entities\Usuario;
use App\Domain\Repositories\UsuarioRepository;
use Illuminate\Support\Facades\DB;

class UsuarioRepositoryMySQL implements UsuarioRepository
{
    public function salvar(Usuario $usuario): void
    {
        DB::table('usuarios')->insert([
            'nome' => $usuario->nome(),
            'email' => $usuario->email()->valor(),
        ]);
    }
}
