<?php

declare(strict_types=1);

namespace App\Application\UseCases;

use App\Application\DTO\CriarUsuarioDTO;
use App\Domain\Entities\Usuario;
use App\Domain\Repositories\UsuarioRepository;
use App\Domain\ValueObjects\Email;

class CriarUsuarioUseCase
{
    public function __construct(
        private UsuarioRepository $repositorio
    ) {}

    public function executar(CriarUsuarioDTO $dto): Usuario
    {
        $email = new Email($dto->email);

        $usuario = new Usuario(
            nome: $dto->nome,
            email: $email
        );

        $this->repositorio->salvar($usuario);

        return $usuario;
    }
}
