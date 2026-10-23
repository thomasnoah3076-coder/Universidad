<?php

namespace App\Http\Controllers;

use App\Models\Club;
use App\Models\Student;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class ClubController extends Controller
{
    /**
     * Listado paginado de clubes.
     */
    public function index(): View
    {
        $clubs = Club::with('president')
            ->withCount('enrollments')
            ->orderBy('name')
            ->paginate(10);

        return view('clubs.index', compact('clubs'));
    }

    /**
     * Formulario de registro con el selector de estudiantes.
     */
    public function create(): View
    {
        $students = $this->estudiantesParaSeleccion();

        return view('clubs.create', compact('students'));
    }

    /**
     * Guarda el club y sus inscripciones.
     */
    public function store(Request $request): RedirectResponse
    {
        $datos = $this->validar($request);
        $seleccionados = $datos['students'] ?? [];
        unset($datos['students']);

        $datos['status'] = $request->boolean('status', true);
        $datos['registered_by'] = $request->user()->id;

        $club = DB::transaction(function () use ($datos, $seleccionados) {
            $club = Club::create($datos);
            $this->sincronizarInscripciones($club, $seleccionados);

            return $club;
        });

        return redirect()
            ->route('clubs.show', $club)
            ->with('success', 'Club registrado correctamente.');
    }

    /**
     * Ficha del club con presidente e inscritos.
     */
    public function show(Club $club): View
    {
        $club->load(['president', 'enrollments.student']);

        return view('clubs.show', compact('club'));
    }

    /**
     * Formulario de edición con los estudiantes ya inscritos.
     */
    public function edit(Club $club): View
    {
        $students = $this->estudiantesParaSeleccion();
        $inscritos = $club->enrollments()->pluck('student_id')->all();

        return view('clubs.edit', compact('club', 'students', 'inscritos'));
    }

    /**
     * Actualiza el club y sincroniza sus inscripciones.
     */
    public function update(Request $request, Club $club): RedirectResponse
    {
        $datos = $this->validar($request, $club);
        $seleccionados = $datos['students'] ?? [];
        unset($datos['students']);

        DB::transaction(function () use ($club, $datos, $seleccionados) {
            $club->update($datos);
            $this->sincronizarInscripciones($club, $seleccionados);
        });

        return redirect()
            ->route('clubs.show', $club)
            ->with('success', 'Club actualizado correctamente.');
    }

    /**
     * Elimina el club y sus inscripciones (las FK no tienen cascade).
     */
    public function destroy(Club $club): RedirectResponse
    {
        DB::transaction(function () use ($club) {
            $club->enrollments()->delete();
            $club->delete();
        });

        return redirect()
            ->route('clubs.index')
            ->with('success', 'Club eliminado correctamente.');
    }

    /**
     * Estudiantes ordenados por apellido para los selects del formulario.
     */
    private function estudiantesParaSeleccion(): Collection
    {
        return Student::orderBy('last_name')->orderBy('first_name')->get();
    }

    /**
     * Deja en enrollments exactamente los estudiantes seleccionados.
     * Los ya inscritos conservan su estado y su fecha; los nuevos entran como activos.
     *
     * @param  array<int, int|string>  $studentIds
     */
    private function sincronizarInscripciones(Club $club, array $studentIds): void
    {
        $studentIds = array_map('intval', $studentIds);

        $consulta = $club->enrollments();

        if ($studentIds === []) {
            $consulta->delete();

            return;
        }

        $consulta->whereNotIn('student_id', $studentIds)->delete();

        $inscritos = array_map('intval', $club->enrollments()->pluck('student_id')->all());
        $nuevos = array_diff($studentIds, $inscritos);

        foreach ($nuevos as $studentId) {
            $club->enrollments()->create([
                'student_id' => $studentId,
                'enrollment_date' => now(),
                'status' => 'active',
            ]);
        }
    }

    /**
     * Reglas de validación compartidas por store y update.
     *
     * @return array<string, mixed>
     */
    private function validar(Request $request, ?Club $club = null): array
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique('clubs', 'name')->ignore($club?->id)],
            'description' => ['nullable', 'string'],
            'foundation_date' => ['nullable', 'date', 'before_or_equal:today'],
            'president_id' => ['nullable', 'integer', 'exists:students,id'],
            'students' => ['nullable', 'array'],
            'students.*' => ['integer', 'exists:students,id'],
        ], [
            'name.required' => 'El nombre del club es obligatorio.',
            'name.unique' => 'Ya existe un club con ese nombre.',
            'foundation_date.before_or_equal' => 'La fecha de fundación no puede ser futura.',
            'president_id.exists' => 'El presidente seleccionado no existe.',
            'students.*.exists' => 'Uno de los estudiantes seleccionados no existe.',
        ]);
    }
}
