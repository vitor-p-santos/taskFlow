<?php

namespace App\Http\Requests;

use App\Domain\Tasks\Enums\PriorityTask;
use App\Domain\Tasks\Enums\StatusTask;
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
      'status' => ['required_without_all:priority', Rule::enum(StatusTask::class)],
      'priority' => ['required_without_all:status', Rule::enum(PriorityTask::class)],
    ];
  }

  public function messages(): array
  {
    return [
      'required_without_all' => 'Informe o status ou a prioridade para atualizar.',
      'status.enum' => 'O status selecionado é inválido.',

      'priority.required_without_all' => 'Informe a prioridade ou o status para atualizar.',
      'priority.enum' => 'A prioridade selecionada é inválida.',
    ];
  }
}
