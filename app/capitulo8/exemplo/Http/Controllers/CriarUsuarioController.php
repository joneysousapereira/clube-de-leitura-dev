<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Application\DTO\CriarUsuarioDTO;
use App\Application\UseCases\CriarUsuarioUseCase;
use App\Http\Requests\CriarUsuarioRequest;

class CriarUsuarioController
{
    public function __construct(
        private CriarUsuarioUseCase $useCase
    ) {}

    public function __invoke(CriarUsuarioRequest $request)
    {
        $dto = new CriarUsuarioDTO(
            $request->nome,
            $request->email
        );

        $usuario = $this->useCase->executar($dto);

        return response()->json([
            'id' => $usuario->id(),
            'nome' => $usuario->nome(),
        ]);
    }
}
