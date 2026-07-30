<?php

namespace App\Domain\Tasks\Requests;

use App\Domain\Tasks\Enum\{PriorityTask, StatusTask};
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PatchTaskRequest extends FormRequest
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
      'status' => ['sometimes', Rule::enum(StatusTask::class)],
      'priority' => ['sometimes', Rule::enum(PriorityTask::class)],
    ];
  }

  public function messages(): array
  {
    return [
      'status.sometimes' => 'O status é obrigatório.',
      'status.enum' => 'O status selecionado é inválido.',

      'priority.sometimes' => 'A prioridade é obrigatória.',
      'priority.enum' => 'A prioridade selecionada é inválida.',

    ];
  }
}
