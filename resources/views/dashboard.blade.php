@extends('layouts.app')

@section('title', 'Panel')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
    <li class="breadcrumb-item active" aria-current="page">Panel</li>
@endsection

@section('page-actions')
    <a href="{{ route('students.index') }}" class="btn btn-outline-secondary">
        <i class="fas fa-user-graduate mr-1"></i>Estudiantes
    </a>
    <a href="{{ route('clubs.index') }}" class="btn btn-primary">
        <i class="fas fa-users mr-1"></i>Clubes
    </a>
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h2 class="card-title">Panel de administración</h2>
                </div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <p class="mb-4">
                        Desde este panel puedes revisar el registro académico y administrar estudiantes y clubes.
                    </p>

                    <a href="{{ route('students.index') }}" class="btn btn-primary mr-2 mb-2">Ver estudiantes</a>
                    <a href="{{ route('clubs.index') }}" class="btn btn-outline-secondary mr-2 mb-2">Ver clubes</a>
                    <a href="{{ route('settings') }}" class="btn btn-outline-secondary mb-2">Configuración</a>
                </div>
            </div>
        </div>
    </div>
@endsection
