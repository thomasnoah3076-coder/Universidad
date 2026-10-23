@extends('layouts.app')

@section('title', 'Clubes')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
    <li class="breadcrumb-item active" aria-current="page">Clubes</li>
@endsection

@section('page-actions')
    <a href="{{ route('clubs.create') }}" class="btn btn-primary">
        <i class="fas fa-plus mr-1"></i>Nuevo club
    </a>
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <h2 class="card-title h6 mb-0">
                {{ $clubs->total() }} {{ $clubs->total() === 1 ? 'club registrado' : 'clubes registrados' }}
            </h2>
        </div>

        @if ($clubs->isEmpty())
            <div class="card-body empty-state text-center py-5">
                <i class="fas fa-users empty-state-icon" aria-hidden="true"></i>
                <p class="mb-3">Todavía no hay clubes registrados.</p>
                <a href="{{ route('clubs.create') }}" class="btn btn-primary">Crear el primero</a>
            </div>
        @else
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th scope="col">Club</th>
                            <th scope="col" class="d-none d-md-table-cell">Presidente</th>
                            <th scope="col" class="d-none d-md-table-cell">Fundación</th>
                            <th scope="col" class="d-none d-md-table-cell text-center">Inscritos</th>
                            <th scope="col" class="d-none d-md-table-cell">Estado</th>
                            <th scope="col" class="text-right">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($clubs as $club)
                            <tr>
                                <td>
                                    <a href="{{ route('clubs.show', $club) }}" class="font-weight-bold">{{ $club->name }}</a>
                                    @if ($club->description)
                                        <span class="d-block small text-muted">
                                            {{ \Illuminate\Support\Str::limit($club->description, 70) }}
                                        </span>
                                    @endif
                                </td>
                                <td class="d-none d-md-table-cell">
                                    @if ($club->president)
                                        <a href="{{ route('students.show', $club->president) }}">
                                            {{ $club->president->first_name }} {{ $club->president->last_name }}
                                        </a>
                                    @else
                                        <span class="text-muted">Sin presidente</span>
                                    @endif
                                </td>
                                <td class="d-none d-md-table-cell">
                                    {{ $club->foundation_date
                                        ? \Illuminate\Support\Carbon::parse($club->foundation_date)->format('d/m/Y')
                                        : 'Sin fecha' }}
                                </td>
                                <td class="d-none d-md-table-cell text-center">{{ $club->enrollments_count }}</td>
                                <td class="d-none d-md-table-cell">
                                    <span class="badge {{ $club->status ? 'badge-success' : 'badge-secondary' }}">
                                        {{ $club->status ? 'Activo' : 'Inactivo' }}
                                    </span>
                                </td>
                                <td class="text-right text-nowrap">
                                    <a href="{{ route('clubs.show', $club) }}" class="btn btn-sm btn-outline-secondary"
                                        title="Ver ficha" aria-label="Ver ficha de {{ $club->name }}">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('clubs.edit', $club) }}" class="btn btn-sm btn-outline-secondary"
                                        title="Editar" aria-label="Editar {{ $club->name }}">
                                        <i class="fas fa-pen"></i>
                                    </a>
                                    <form action="{{ route('clubs.destroy', $club) }}" method="POST" class="d-inline"
                                        data-confirm="¿Eliminar el club {{ $club->name }}? También se borrarán sus inscripciones.">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger" title="Eliminar"
                                            aria-label="Eliminar {{ $club->name }}">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            @if ($clubs->hasPages())
                <div class="card-footer bg-white">
                    {{ $clubs->links('pagination::bootstrap-4') }}
                </div>
            @endif
        @endif
    </div>
@endsection
