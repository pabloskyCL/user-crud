<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => ['required',
            'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&.#_\-\/])([A-Za-z\d@$!%*?&.#_\-\/]|[^ ]){8,15}$/'],
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'El campo nombre es obligatorio',
            'email.unique' => 'Ya existe una cuenta con este correo',
            'email.required' => 'El campo email es obligatorio',
            'email.email' => 'El campo email no es valido',
            'password.regex' => 'El campo contraseña no cumple con los requisitos de contraseña',
            'password.required' => 'El campo contraseña es obligatorio',
        ];
    }
}
