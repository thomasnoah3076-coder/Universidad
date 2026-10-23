<?php

namespace App\Http\Controllers;

use App\Models\Club;
use App\Models\Enrollment;
use App\Models\Student;
use Illuminate\Contracts\View\View;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Página de inicio con el resumen del registro.
     */
    public function index(): View
    {
        return view('home', [
            'totalEstudiantes' => Student::count(),
            'totalClubes' => Club::count(),
            'totalInscripciones' => Enrollment::count(),
            'inscripcionesActivas' => Enrollment::where('status', 'active')->count(),
        ]);
    }
}
