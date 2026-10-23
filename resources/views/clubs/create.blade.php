@extends('layouts.app')

@section('title', 'Nuevo club')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
    <li class="breadcrumb-item"><a href="{{ route('clubs.index') }}">Clubes</a></li>
    <li class="breadcrumb-item active" aria-current="page">Nuevo</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h2 class="card-title h6 mb-0">Datos del club</h2>
                </div>

                <form action="{{ route('clubs.store') }}" method="POST">
                    @csrf

                    <div class="card-body">
                        @include('clubs._form')
                    </div>

                    <div class="card-footer bg-white">
                        <button type="submit" class="btn btn-primary">Guardar club</button>
                        <a href="{{ route('clubs.index') }}" class="btn btn-outline-secondary">Cancelar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection