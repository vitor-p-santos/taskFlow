<?php

namespace App\Http\Requests;

use App\Enums\PriorityTask;
use App\Enums\StatusTask;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class NewTaskRequest extends FormRequest
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
            'title' => 'required|string|max:100|regex:/^(?=.{5,}$)(?=(?:.*[A-Za-zÀ-ÿ]){2,})(?!^\d+$).+$/u',
            'description' => 'required|string|min:5|max:255',
            'status' => ['required', Rule::enum(StatusTask::class)],
            'priority' => ['required', Rule::enum(PriorityTask::class)],
            'due_date' => 'required|date|after_or_equal:today',
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
            'title.required' => 'O título é obrigatório.',
            'title.string' => 'O título deve ser um texto válido.',
            'title.max' => 'O título deve ter no máximo 100 caracteres.',
            'title.regex' => 'O nome deve conter pelo menos 5 caracteres e deve conter letras. Não pode ser composto apenas por números.',

            'description.required' => 'A descrição é obrigatória.',
            'description.string' => 'A descrição deve ser um texto válido.',
            'description.min' => 'A descrição deve conter pelo menos 5 caracteres.',
            'description.max' => 'A descrição deve ter no máximo 255 caracteres.',

            'status.required' => 'O status é obrigatório.',
            'status.enum' => 'O status selecionado é inválido.',

            'priority.required' => 'A prioridade é obrigatória.',
            'priority.enum' => 'A prioridade selecionada é inválida.',

            'due_date.required' => 'A data de vencimento é obrigatória.',
            'due_date.date' => 'A data de vencimento deve ser uma data válida.',
            'due_date.after_or_equal' => 'A data de vencimento não pode ser uma data passada.',
        ];
    }
}
