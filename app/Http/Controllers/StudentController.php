<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class StudentController extends Controller
{
    /**
     * Listado paginado de estudiantes.
     */
    public function index(): View
    {
        $students = Student::withCount('enrollments')
            ->orderBy('last_name')
            ->orderBy('first_name')
            ->paginate(10);

        return view('students.index', compact('students'));
    }

    /**
     * Formulario de registro.
     */
    public function create(): View
    {
        return view('students.create');
    }

    /**
     * Guarda un estudiante nuevo.
     */
    public function store(Request $request): RedirectResponse
    {
        Student::create($this->validar($request));

        return redirect()
            ->route('students.index')
            ->with('success', 'Estudiante registrado correctamente.');
    }

    /**
     * Ficha del estudiante con sus clubes.
     */
    public function show(Student $student): View
    {
        $student->load('enrollments.club');

        return view('students.show', compact('student'));
    }

    /**
     * Formulario de edición.
     */
    public function edit(Student $student): View
    {
        return view('students.edit', compact('student'));
    }

    /**
     * Actualiza los datos del estudiante.
     */
    public function update(Request $request, Student $student): RedirectResponse
    {
        $student->update($this->validar($request, $student));

        return redirect()
            ->route('students.show', $student)
            ->with('success', 'Estudiante actualizado correctamente.');
    }

    /**
     * Elimina el estudiante y sus inscripciones.
     * Las claves foráneas de enrollments no tienen cascade, por eso se borran primero.
     */
    public function destroy(Student $student): RedirectResponse
    {
        DB::transaction(function () use ($student) {
            $student->enrollments()->delete();
            $student->delete();
        });

        return redirect()
            ->route('students.index')
            ->with('success', 'Estudiante eliminado correctamente.');
    }

    /**
     * Reglas de validación compartidas por store y update.
     *
     * @return array<string, mixed>
     */
    private function validar(Request $request, ?Student $student = null): array
    {
        return $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('students', 'email')->ignore($student?->id)],
            'date_of_birth' => ['nullable', 'date', 'before:today'],
            'degree_program' => ['nullable', 'string', 'max:255'],
            'registration_date' => ['nullable', 'date'],
        ], [
            'first_name.required' => 'El nombre es obligatorio.',
            'last_name.required' => 'El apellido es obligatorio.',
            'email.required' => 'El correo es obligatorio.',
            'email.email' => 'Escribe un correo válido.',
            'email.unique' => 'Ya existe un estudiante con ese correo.',
            'date_of_birth.before' => 'La fecha de nacimiento debe ser anterior a hoy.',
            'registration_date.date' => 'La fecha de registro no es válida.',
        ]);
    }
}
