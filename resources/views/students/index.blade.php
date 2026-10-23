@extends('layouts.app')

@section('title', 'Estudiantes')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
    <li class="breadcrumb-item active" aria-current="page">Estudiantes</li>
@endsection

@section('page-actions')
    <a href="{{ route('students.create') }}" class="btn btn-primary">
        <i class="fas fa-plus mr-1"></i>Nuevo estudiante
    </a>
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <h2 class="card-title h6 mb-0">
                {{ $students->total() }} {{ $students->total() === 1 ? 'estudiante registrado' : 'estudiantes registrados' }}
            </h2>
        </div>

        @if ($students->isEmpty())
            <div class="card-body empty-state text-center py-5">
                <i class="fas fa-user-graduate empty-state-icon" aria-hidden="true"></i>
                <p class="mb-3">Todavía no hay estudiantes registrados.</p>
                <a href="{{ route('students.create') }}" class="btn btn-primary">Registrar el primero</a>
            </div>
        @else
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th scope="col">Estudiante</th>
                            <th scope="col" class="d-none d-md-table-cell">Programa</th>
                            <th scope="col" class="d-none d-md-table-cell">Registro</th>
                            <th scope="col" class="d-none d-md-table-cell text-center">Clubes</th>
                            <th scope="col" class="text-right">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($students as $student)
                            <tr>
                                <td>
                                    <a href="{{ route('students.show', $student) }}" class="font-weight-bold">
                                        {{ $student->first_name }} {{ $student->last_name }}
                                    </a>
                                    <span class="d-block small text-muted">{{ $student->email }}</span>
                                </td>
                                <td class="d-none d-md-table-cell">{{ $student->degree_program ?? 'Sin programa' }}</td>
                                <td class="d-none d-md-table-cell">
                                    {{ $student->registration_date
                                        ? \Illuminate\Support\Carbon::parse($student->registration_date)->format('d/m/Y')
                                        : 'Sin fecha' }}
                                </td>
                                <td class="d-none d-md-table-cell text-center">{{ $student->enrollments_count }}</td>
                                <td class="text-right text-nowrap">
                                    <a href="{{ route('students.show', $student) }}" class="btn btn-sm btn-outline-secondary"
                                        title="Ver ficha" aria-label="Ver ficha de {{ $student->first_name }} {{ $student->last_name }}">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('students.edit', $student) }}" class="btn btn-sm btn-outline-secondary"
                                        title="Editar" aria-label="Editar a {{ $student->first_name }} {{ $student->last_name }}">
                                        <i class="fas fa-pen"></i>
                                    </a>
                                    <form action="{{ route('students.destroy', $student) }}" method="POST" class="d-inline"
                                        data-confirm="¿Eliminar a {{ $student->first_name }} {{ $student->last_name }}? También se borrarán sus inscripciones.">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger" title="Eliminar"
                                            aria-label="Eliminar a {{ $student->first_name }} {{ $student->last_name }}">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            @if ($students->hasPages())
                <div class="card-footer bg-white">
                    {{ $students->links('pagination::bootstrap-4') }}
                </div>
            @endif
        @endif
    </div>
@endsection
