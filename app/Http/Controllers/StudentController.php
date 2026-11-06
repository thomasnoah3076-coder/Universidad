<?php

namespace App\Http\Controllers;

use App\Http\Requests\EstudianteRequest;
use App\Models\Student;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

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
     * Guarda el usuario autenticable, el estudiante y su fotografía.
     */
    public function store(EstudianteRequest $request): RedirectResponse
    {
        $datos = $request->validated();
        $imagen = $this->guardarImagen($request);

        try {
            DB::transaction(function () use ($datos, $imagen) {
                $user = new User;
                $user->name = trim($datos['first_name'].' '.$datos['last_name']);
                $user->email = $datos['email'];
                $user->email_verified_at = now();
                $user->password = Hash::make($datos['numerodocumento']);
                $user->remember_token = Str::random(40);
                $user->save();

                Student::create([
                    'user_id' => $user->id,
                    'first_name' => $datos['first_name'],
                    'last_name' => $datos['last_name'],
                    'email' => $datos['email'],
                    'numerodocumento' => $datos['numerodocumento'],
                    'date_of_birth' => $datos['date_of_birth'] ?? null,
                    'degree_program' => $datos['degree_program'] ?? null,
                    'registration_date' => $datos['registration_date'] ?? null,
                    'image' => $imagen,
                ]);
            });
        } catch (\Throwable $e) {
            $this->eliminarImagen($imagen);
            throw $e;
        }

        return redirect()
            ->route('students.index')
            ->with('success', 'Student registered successfully.');
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
     * Actualiza los datos del estudiante y, si existe, su usuario vinculado.
     */
    public function update(EstudianteRequest $request, Student $student): RedirectResponse
    {
        $datos = $request->validated();
        $nuevaImagen = $this->guardarImagen($request);
        $imagenAnterior = $student->image;

        try {
            DB::transaction(function () use ($datos, $nuevaImagen, $student) {
                $student->update([
                    'first_name' => $datos['first_name'],
                    'last_name' => $datos['last_name'],
                    'email' => $datos['email'],
                    'numerodocumento' => $datos['numerodocumento'] ?? $student->numerodocumento,
                    'date_of_birth' => $datos['date_of_birth'] ?? null,
                    'degree_program' => $datos['degree_program'] ?? null,
                    'registration_date' => $datos['registration_date'] ?? null,
                    'image' => $nuevaImagen ?? $student->image,
                ]);

                if ($student->user) {
                    $student->user->update([
                        'name' => trim($datos['first_name'].' '.$datos['last_name']),
                        'email' => $datos['email'],
                    ]);
                }
            });
        } catch (\Throwable $e) {
            $this->eliminarImagen($nuevaImagen);
            throw $e;
        }

        if ($nuevaImagen) {
            $this->eliminarImagen($imagenAnterior);
        }

        return redirect()
            ->route('students.show', $student)
            ->with('success', 'Student updated successfully.');
    }

    /**
     * Elimina el estudiante, sus inscripciones, su usuario vinculado y su foto.
     * Las claves foráneas de enrollments no tienen cascade, por eso se borran primero.
     */
    public function destroy(Student $student): RedirectResponse
    {
        $user = $student->user;
        $imagen = $student->image;

        DB::transaction(function () use ($student, $user) {
            $student->enrollments()->delete();
            $student->delete();

            if ($user && $user->id !== auth()->id()) {
                $user->delete();
            }
        });

        $this->eliminarImagen($imagen);

        return redirect()
            ->route('students.index')
            ->with('success', 'Student deleted successfully.');
    }

    /**
     * Mueve la fotografía a public/uploads/personas/estudiantes.
     */
    private function guardarImagen(EstudianteRequest $request): ?string
    {
        if (! $request->hasFile('image')) {
            return null;
        }

        $archivo = $request->file('image');
        $slug = Str::slug($request->input('first_name').' '.$request->input('last_name')) ?: 'estudiante';
        $nombreArchivo = $slug.'-'.Carbon::now()->toDateString().'-'.uniqid().'.'.$archivo->getClientOriginalExtension();
        $directorio = public_path('uploads/personas/estudiantes');

        File::ensureDirectoryExists($directorio, 0775, true);
        $archivo->move($directorio, $nombreArchivo);

        return 'uploads/personas/estudiantes/'.$nombreArchivo;
    }

    /**
     * Borra una foto del disco solo si está dentro de uploads/personas/estudiantes.
     */
    private function eliminarImagen(?string $ruta): void
    {
        if (! $ruta || ! str_starts_with($ruta, 'uploads/personas/estudiantes/')) {
            return;
        }

        $absoluta = public_path($ruta);

        if (File::isFile($absoluta)) {
            File::delete($absoluta);
        }
    }
}
