<?php

namespace App\Http\Requests;

use App\Models\Club;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ClubRequest extends FormRequest
{
    /**
     * La autorización la resuelve el middleware auth de la ruta.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Reglas compartidas por store y update.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        /** @var Club|null $club */
        $club = $this->route('club');

        return [
            'name' => ['required', 'string', 'max:255', Rule::unique('clubs', 'name')->ignore($club?->id)],
            'description' => ['nullable', 'string'],
            'foundation_date' => ['nullable', 'date', 'before_or_equal:today'],
            'president_id' => ['nullable', 'integer', 'exists:students,id'],
            'students' => ['nullable', 'array'],
            'students.*' => ['integer', 'exists:students,id'],
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
            'name.required' => 'The club name is required.',
            'name.unique' => 'A club with that name already exists.',
            'foundation_date.before_or_equal' => 'The foundation date cannot be in the future.',
            'president_id.exists' => 'The selected president does not exist.',
            'students.*.exists' => 'One of the selected students does not exist.',
        ];
    }
}