@extends('layouts.app')

@section('title', 'Editar club')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
    <li class="breadcrumb-item"><a href="{{ route('clubs.index') }}">Clubes</a></li>
    <li class="breadcrumb-item"><a href="{{ route('clubs.show', $club) }}">{{ $club->name }}</a></li>
    <li class="breadcrumb-item active" aria-current="page">Editar</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h2 class="card-title h6 mb-0">Datos del club</h2>
                </div>

                <form action="{{ route('clubs.update', $club) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="card-body">
                        @include('clubs._form', ['club' => $club, 'inscritos' => $inscritos])
                    </div>

                    <div class="card-footer bg-white">
                        <button type="submit" class="btn btn-primary">Guardar cambios</button>
                        <a href="{{ route('clubs.show', $club) }}" class="btn btn-outline-secondary">Cancelar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
