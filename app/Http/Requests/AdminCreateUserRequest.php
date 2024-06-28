<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdminCreateUserRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => 'required',
            'email' => 'required|email',
            'password' => ['required',
            'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&.#_\-\/])([A-Za-z\d@$!%*?&.#_\-\/]|[^ ]){8,15}$/'],
            'role' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'nombre es obligatorio',
            'email.email' => 'email no valido, verifica si esta bien escrito',
            'email.required' => 'email es obligatorio',
            'password.required' => 'contraseña es obligatorio',
            'password.regex' => 'formato de contraseña incorrecto',
            'role.required' => 'role es obligatorio',
        ];
    }
}
