<?php

namespace App\Domain\Projects\Requests;

use App\Domain\Projects\Enum\StatusProject;
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
            'name'     => ['nullable', 'string', ],
            'status'   => ['nullable', Rule::enum(StatusProject::class)],
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
            'name.string'          => 'o parametro name é invalido',
            'status.enum'          => 'O parametro status é invalido.',
        ];
    }
}
