<?php

namespace App\Domain\Tasks\Requests;

use App\Domain\Tasks\Enum\{PriorityTask, StatusTask};
use App\Domain\Tasks\Enum\DueDateBoolean;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class GetParamsRequest extends FormRequest
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
            'status'   => ['nullable', Rule::enum(StatusTask::class)],
            'priority' => ['nullable', Rule::enum(PriorityTask::class)],
            'due_date' => ['nullable', Rule::enum(DueDateBoolean::class)],
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
            'status.enum'      => 'O status selecionado é inválido.',
            'priority.enum'    => 'A prioridade selecionada é inválida.',
            'due_date.enum' => 'O filtro de data de vencimento deve ser true.',
        ];
    }
}
