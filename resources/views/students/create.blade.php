@extends('layouts.app')

@section('title', 'Nuevo estudiante')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
    <li class="breadcrumb-item"><a href="{{ route('students.index') }}">Estudiantes</a></li>
    <li class="breadcrumb-item active" aria-current="page">Nuevo</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h2 class="card-title h6 mb-0">Datos del estudiante</h2>
                </div>

                <form action="{{ route('students.store') }}" method="POST">
                    @csrf

                    <div class="card-body">
                        @include('students._form')
                    </div>

                    <div class="card-footer bg-white">
                        <button type="submit" class="btn btn-primary">Guardar estudiante</button>
                        <a href="{{ route('students.index') }}" class="btn btn-outline-secondary">Cancelar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
