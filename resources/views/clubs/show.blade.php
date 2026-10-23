@extends('layouts.app')

@section('title', 'Ficha del club')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
    <li class="breadcrumb-item"><a href="{{ route('clubs.index') }}">Clubes</a></li>
    <li class="breadcrumb-item active" aria-current="page">{{ $club->name }}</li>
@endsection

@section('page-actions')
    <a href="{{ route('clubs.edit', $club) }}" class="btn btn-primary">
        <i class="fas fa-pen mr-1"></i>Editar
    </a>
    <a href="{{ route('clubs.index') }}" class="btn btn-outline-secondary">Volver al listado</a>
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-5">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h2 class="card-title h6 mb-0">{{ $club->name }}</h2>
                    <span class="badge {{ $club->status ? 'badge-success' : 'badge-secondary' }}">
                        {{ $club->status ? 'Activo' : 'Inactivo' }}
                    </span>
                </div>
                <div class="card-body">
                    <dl class="row mb-0">
                        <dt class="col-sm-5">Fundación</dt>
                        <dd class="col-sm-7">
                            {{ $club->foundation_date
                                ? \Illuminate\Support\Carbon::parse($club->foundation_date)->format('d/m/Y')
                                : 'Sin registrar' }}
                        </dd>

                        <dt class="col-sm-5">Presidente</dt>
                        <dd class="col-sm-7">
                            @if ($club->president)
                                <a href="{{ route('students.show', $club->president) }}">
                                    {{ $club->president->first_name }} {{ $club->president->last_name }}
                                </a>
                            @else
                                <span class="text-muted">Sin presidente</span>
                            @endif
                        </dd>

                        <dt class="col-sm-5">Inscritos</dt>
                        <dd class="col-sm-7 mb-0">{{ $club->enrollments->count() }}</dd>
                    </dl>

                    @if ($club->description)
                        <hr>
                        <p class="mb-0">{{ $club->description }}</p>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-lg-7">
            <div class="card">
                <div class="card-header">
                    <h2 class="card-title h6 mb-0">Miembros del club</h2>
                </div>

                @if ($club->enrollments->isEmpty())
                    <div class="card-body text-center py-5">
                        <i class="fas fa-user-graduate empty-state-icon" aria-hidden="true"></i>
                        <p class="mb-3">Este club todavía no tiene estudiantes inscritos.</p>
                        <a href="{{ route('clubs.edit', $club) }}" class="btn btn-primary">Inscribir estudiantes</a>
                    </div>
                @else
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr>
                                    <th scope="col">Estudiante</th>
                                    <th scope="col">Inscripción</th>
                                    <th scope="col">Estado</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($club->enrollments as $inscripcion)
                                    <tr>
                                        <td>
                                            @if ($inscripcion->student)
                                                <a href="{{ route('students.show', $inscripcion->student) }}" class="font-weight-bold">
                                                    {{ $inscripcion->student->first_name }} {{ $inscripcion->student->last_name }}
                                                </a>
                                                <span class="d-block small text-muted">{{ $inscripcion->student->email }}</span>
                                            @else
                                                <span class="text-muted">Estudiante no disponible</span>
                                            @endif
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
