<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => 'required',
            'email' => 'required|email',
            'role' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'nombre es obligatorio',
            'email.email' => 'email no valido, verifica si esta bien escrito',
            'email.required' => 'email es obligatorio',
            'role.required' => 'role es obligatorio'
        ];
    }
}
