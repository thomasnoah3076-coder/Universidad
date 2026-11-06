<?php

namespace App\Http\Requests;

use App\Models\Student;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class EstudianteRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        /** @var Student|null $student */
        $student = $this->route('student');
        $userId = $student?->user_id;

        return [
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('students', 'email')->ignore($student?->id),
                Rule::unique('users', 'email')->ignore($userId),
            ],
            'numerodocumento' => [
                $student ? 'nullable' : 'required',
                'string',
                'max:255',
                Rule::unique('students', 'numerodocumento')->ignore($student?->id),
            ],
            'date_of_birth' => ['nullable', 'date', 'before:today'],
            'degree_program' => ['nullable', 'string', 'max:255'],
            'registration_date' => ['nullable', 'date'],
            'image' => ['nullable', 'image', 'max:2048'],
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
            'first_name.required' => 'The first name is required.',
            'last_name.required' => 'The last name is required.',
            'email.required' => 'The email address is required.',
            'email.email' => 'Enter a valid email address.',
            'email.unique' => 'A user or student with that email address already exists.',
            'numerodocumento.required' => 'The document number is required.',
            'numerodocumento.unique' => 'A student with that document number already exists.',
            'date_of_birth.before' => 'The date of birth must be before today.',
            'registration_date.date' => 'The registration date is not valid.',
            'image.image' => 'The file must be an image.',
            'image.max' => 'The image cannot be larger than 2 MB.',
        ];
    }
}
