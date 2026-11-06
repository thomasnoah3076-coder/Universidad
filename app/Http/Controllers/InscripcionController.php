<?php

namespace App\Http\Controllers;

use App\Http\Requests\InscripcionRequest;
use App\Models\Club;
use App\Models\Enrollment;
use App\Models\Student;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;

class InscripcionController extends Controller
{
    /**
     * Clubes activos con sus estudiantes inscritos (eager loading, sin N+1).
     */
    public function index(): View
    {
        $clubs = Club::where('status', true)
            ->with('estudiantes')
            ->withCount('estudiantes')
            ->orderBy('name')
            ->get();

        return view('inscripciones.index', compact('clubs'));
    }

    /**
     * Formulario con todos los estudiantes y los clubes activos.
     */
    public function create(): View
    {
        $students = $this->estudiantesParaSeleccion();
        $clubs = $this->clubesParaSeleccion();

        return view('inscripciones.create', compact('students', 'clubs'));
    }

    /**
     * Inscribe cada estudiante seleccionado en cada club seleccionado.
     */
    public function store(InscripcionRequest $request): RedirectResponse
    {
        $datos = $request->validated();
        $studentIds = array_map('intval', $datos['estudiantes']);
        $clubIds = array_map('intval', $datos['clubes']);
        $registeredBy = $request->user()->id;

        [$nuevas, $existentes] = DB::transaction(function () use ($studentIds, $clubIds, $registeredBy) {
            $nuevas = 0;
            $existentes = 0;

            foreach ($clubIds as $clubId) {
                foreach ($studentIds as $studentId) {
                    $inscripcion = Enrollment::firstOrCreate(
                        [
                            'student_id' => $studentId,
                            'club_id' => $clubId,
                        ],
                        [
                            'enrollment_date' => now(),
                            'status' => 'active',
                            'registered_by' => $registeredBy,
                        ]
                    );

                    $inscripcion->wasRecentlyCreated ? $nuevas++ : $existentes++;
                }
            }

            return [$nuevas, $existentes];
        });

        return redirect()
            ->route('inscripciones.index')
            ->with('successMsg', $this->mensaje($nuevas, $existentes));
    }

    /**
     * Estudiantes ordenados por apellido para el multi-select.
     */
    private function estudiantesParaSeleccion(): Collection
    {
        return Student::orderBy('last_name')->orderBy('first_name')->get();
    }

    /**
     * Clubes activos ordenados por nombre para el multi-select.
     */
    private function clubesParaSeleccion(): Collection
    {
        return Club::where('status', true)->orderBy('name')->get();
    }

    /**
     * Resumen de la operación para el mensaje flash.
     */
    private function mensaje(int $nuevas, int $existentes): string
    {
        $mensaje = $nuevas === 1
            ? '1 new enrollment was created.'
            : "{$nuevas} new enrollments were created.";

        if ($existentes > 0) {
            $mensaje .= $existentes === 1
                ? ' 1 already existed and was skipped.'
                : " {$existentes} already existed and were skipped.";
        }

        return $mensaje;
    }
}
