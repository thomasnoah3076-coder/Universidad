@extends('layouts.app')

@section('title', 'Configuración')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
    <li class="breadcrumb-item active" aria-current="page">Configuración</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h2 class="card-title">Preferencias de la aplicación</h2>
                </div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <dl class="row mb-4">
                        <dt class="col-sm-4">Aplicación</dt>
                        <dd class="col-sm-8">Universidad</dd>

                        <dt class="col-sm-4">Registro</dt>
                        <dd class="col-sm-8">Estudiantes, clubes e inscripciones</dd>

                        <dt class="col-sm-4">Tecnología</dt>
                        <dd class="col-sm-8">Laravel 13 con AdminLTE 3</dd>
                    </dl>

                    <p class="text-muted mb-4">
                        Todavía no hay preferencias editables en esta versión.
                    </p>

                    <a href="{{ route('home') }}" class="btn btn-primary">Volver al inicio</a>
                </div>
            </div>
        </div>
    </div>
@endsection
