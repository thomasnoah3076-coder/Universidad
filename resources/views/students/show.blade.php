@extends('layouts.app')

@section('title', 'Ficha del estudiante')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
    <li class="breadcrumb-item"><a href="{{ route('students.index') }}">Estudiantes</a></li>
    <li class="breadcrumb-item active" aria-current="page">{{ $student->first_name }} {{ $student->last_name }}</li>
@endsection

@section('page-actions')
    <a href="{{ route('students.edit', $student) }}" class="btn btn-primary">
        <i class="fas fa-pen mr-1"></i>Editar
    </a>
    <a href="{{ route('students.index') }}" class="btn btn-outline-secondary">Volver al listado</a>
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-5">
            <div class="card">
                <div class="card-header">
                    <h2 class="card-title h6 mb-0">{{ $student->first_name }} {{ $student->last_name }}</h2>
                </div>
                <div class="card-body">
                    <dl class="row mb-0">
                        <dt class="col-sm-5">Correo</dt>
                        <dd class="col-sm-7">{{ $student->email }}</dd>

                        <dt class="col-sm-5">Nacimiento</dt>
                        <dd class="col-sm-7">
                            {{ $student->date_of_birth
                                ? \Illuminate\Support\Carbon::parse($student->date_of_birth)->format('d/m/Y')
                                : 'Sin registrar' }}
                        </dd>

                        <dt class="col-sm-5">Programa</dt>
                        <dd class="col-sm-7">{{ $student->degree_program ?? 'Sin programa' }}</dd>

                        <dt class="col-sm-5">Fecha de registro</dt>
                        <dd class="col-sm-7 mb-0">
                            {{ $student->registration_date
                                ? \Illuminate\Support\Carbon::parse($student->registration_date)->format('d/m/Y')
                                : 'Sin registrar' }}
                        </dd>
                    </dl>
                </div>
            </div>
        </div>

        <div class="col-lg-7">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h2 class="card-title h6 mb-0">Clubes inscritos</h2>
                    <span class="text-muted small">{{ $student->enrollments->count() }}</span>
                </div>

                @if ($student->enrollments->isEmpty())
                    <div class="card-body text-center py-5">
                        <i class="fas fa-users empty-state-icon" aria-hidden="true"></i>
                        <p class="mb-0">Este estudiante todavía no está inscrito en ningún club.</p>
                    </div>
                @else
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr>
                                    <th scope="col">Club</th>
                                    <th scope="col">Inscripción</th>
                                    <th scope="col">Estado</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($student->enrollments as $inscripcion)
                                    <tr>
                                        <td>
                                            <a href="{{ route('clubs.show', $inscripcion->club) }}" class="font-weight-bold">
                                                {{ $inscripcion->club->name }}
                                            </a>
                                        </td>
                                        <td>
                                            {{ $inscripcion->enrollment_date
                                                ? \Illuminate\Support\Carbon::parse($inscripcion->enrollment_date)->format('d/m/Y')
                                                : 'Sin fecha' }}
                                        </td>
                                        <td>@include('layouts.partials.status-badge', ['status' => $inscripcion->status])</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
