<?php

namespace App\Http\Requests;

use App\Domain\Tasks\Enums\DueDateBoolean;
use App\Domain\Tasks\Enums\PriorityTask;
use App\Domain\Tasks\Enums\StatusTask;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class GetParamsTasksRequest extends FormRequest
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
