@extends('layouts.app')

@section('title', 'Inicio')

@section('breadcrumbs')
    <li class="breadcrumb-item active" aria-current="page">Inicio</li>
@endsection

@section('page-actions')
    <a href="{{ route('students.create') }}" class="btn btn-outline-secondary">
        <i class="fas fa-user-plus mr-1"></i>Nuevo estudiante
    </a>
    <a href="{{ route('clubs.create') }}" class="btn btn-primary">
        <i class="fas fa-plus mr-1"></i>Nuevo club
    </a>
@endsection

@section('content')
    <section class="ledger" aria-labelledby="ledger-title">
        <div class="ledger-masthead">
            <div>
                <h2 id="ledger-title" class="ledger-title">Resumen del registro</h2>
                <p class="ledger-subtitle">Estudiantes, clubes e inscripciones registrados.</p>
            </div>
            <span class="ledger-date">{{ now()->format('d/m/Y') }}</span>
        </div>

        <div class="ledger-figures">
            <div class="ledger-figure">
                <span class="ledger-label">Estudiantes</span>
                <span class="ledger-number">{{ number_format($totalEstudiantes) }}</span>
                <a href="{{ route('students.index') }}" class="ledger-link">Ver estudiantes</a>
            </div>

            <div class="ledger-figure">
                <span class="ledger-label">Clubes</span>
                <span class="ledger-number">{{ number_format($totalClubes) }}</span>
                <a href="{{ route('clubs.index') }}" class="ledger-link">Ver clubes</a>
            </div>

            <div class="ledger-figure">
                <span class="ledger-label">Inscripciones</span>
                <span class="ledger-number">{{ number_format($totalInscripciones) }}</span>
                <span class="ledger-note">{{ number_format($inscripcionesActivas) }} activas</span>
            </div>
        </div>
    </section>

    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h2 class="card-title">Cómo usar el registro</h2>
                </div>
                <div class="card-body">
                    <ol class="mb-0 pl-3">
                        <li class="mb-2">Registra estudiantes con su correo y programa académico.</li>
                        <li class="mb-2">Crea un club y elige a su presidente.</li>
                        <li>En el formulario del club, selecciona los estudiantes que quieres inscribir.</li>
                    </ol>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h2 class="card-title">Accesos rápidos</h2>
                </div>
                <div class="list-group list-group-flush">
                    <a href="{{ route('students.index') }}" class="list-group-item list-group-item-action">
                        <i class="fas fa-user-graduate mr-2 text-muted"></i>Listado de estudiantes
                    </a>
                    <a href="{{ route('clubs.index') }}" class="list-group-item list-group-item-action">
                        <i class="fas fa-users mr-2 text-muted"></i>Listado de clubes
                    </a>
                    <a href="{{ route('settings') }}" class="list-group-item list-group-item-action">
                        <i class="fas fa-cog mr-2 text-muted"></i>Configuración
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
