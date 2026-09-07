<?php

namespace App\Http\Requests\Auth;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'min:4', 'max:25', 'regex:/[A-Za-z]/'],
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'string', 'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,}$/', 'same:confirmPassword'],
            'confirmPassword' => ['required', 'string'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'O campo nome é obrigatório.',
            'name.min' => 'O nome deve ter pelo menos :min caracteres.',
            'name.max' => 'O nome não pode ter mais de :max caracteres.',
            'name.regex' => 'O nome só pode conter letas.',

            'email.required' => 'O e-mail é obrigatório.',
            'email.email' => 'Informe um e-mail válido.',
            'email.unique' => 'Este e-mail já está sendo utilizado.',

            'password.required' => 'A senha é obrigatória.',
            'password.regex' => 'A senha deve ter no mínimo 8 caracteres, contendo 1 letra maiúscula, 1 minúscula, 1 número e 1 caractere especial.',
            'password.same' => 'As senhas não coincidem.',

            'confirmPassword.required' => 'A confirmação de senha é obrigatória.',
        ];
    }
}
