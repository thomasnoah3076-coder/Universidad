<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class InscripcionRequest extends FormRequest
{
    /**
     * La autorización la resuelve el middleware auth de la ruta.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Estudiantes y clubes seleccionados para el producto cartesiano.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'estudiantes' => ['required', 'array', 'min:1'],
            'estudiantes.*' => ['integer', 'distinct', 'exists:students,id'],
            'clubes' => ['required', 'array', 'min:1'],
            'clubes.*' => [
                'integer',
                'distinct',
                Rule::exists('clubs', 'id')->where('status', true),
            ],
        ];
    }

    /**
     * Messages for the rules above.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'estudiantes.required' => 'Select at least one student.',
            'estudiantes.array' => 'The student selection is not valid.',
            'estudiantes.min' => 'Select at least one student.',
            'estudiantes.*.integer' => 'One of the selected students is not valid.',
            'estudiantes.*.distinct' => 'Do not repeat students in the selection.',
            'estudiantes.*.exists' => 'One of the selected students does not exist.',
            'clubes.required' => 'Select at least one club.',
            'clubes.array' => 'The club selection is not valid.',
            'clubes.min' => 'Select at least one club.',
            'clubes.*.integer' => 'One of the selected clubs is not valid.',
            'clubes.*.distinct' => 'Do not repeat clubs in the selection.',
            'clubes.*.exists' => 'One of the selected clubs does not exist or is not active.',
        ];
    }
}
