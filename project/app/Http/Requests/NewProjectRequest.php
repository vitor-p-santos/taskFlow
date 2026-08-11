<?php

namespace App\Http\Requests;

use App\Enums\StatusProject;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class NewProjectRequest extends FormRequest
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
            'name' => 'required|string|max:100|regex:/^(?=.{5,}$)(?=(?:.*[A-Za-zÀ-ÿ]){2,})(?!^\d+$).+$/u',
            'description' => 'required|string|min:5|max:255',
            'status' => ['required', Rule::enum(StatusProject::class)],
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [

            'name.required' => 'O nome é obrigatório.',
            'name.string' => 'O nome deve ser um texto válido.',
            'name.max' => 'O nome deve ter no máximo 100 caracteres.',
            'name.regex' => 'O nome deve conter pelo menos 5 caracteres e deve conter letras. Não pode ser composto apenas por números.',

            'description.required' => 'A descrição é obrigatória.',
            'description.string' => 'A descrição deve ser um texto válido.',
            'description.min' => 'A descrição deve conter pelo menos 5 caracteres.',
            'description.max' => 'A descrição deve ter no máximo 255 caracteres.',

            'status.required' => 'O status é obrigatório.',
            'status.enum' => 'O status selecionado é inválido.',
        ];
    }
}
