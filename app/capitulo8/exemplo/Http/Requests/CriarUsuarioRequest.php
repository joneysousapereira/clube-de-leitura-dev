<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CriarUsuarioRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'nome' => ['required', 'string'],
            'email' => ['required', 'email'],
        ];
    }
}
