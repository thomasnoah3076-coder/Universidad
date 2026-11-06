@extends('layouts.app')

@section('title', 'New enrollment')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
    <li class="breadcrumb-item"><a href="{{ route('inscripciones.index') }}">Enrollments</a></li>
    <li class="breadcrumb-item active" aria-current="page">New</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h2 class="card-title h6 mb-0">Students and clubs</h2>
                </div>

                <form action="{{ route('inscripciones.store') }}" method="POST">
                    @csrf

                    <div class="card-body">
                        @include('inscripciones._form')
                    </div>

                    <div class="card-footer bg-white">
                        <button type="submit" class="btn btn-primary">Save enrollments</button>
                        <a href="{{ route('inscripciones.index') }}" class="btn btn-outline-secondary">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
