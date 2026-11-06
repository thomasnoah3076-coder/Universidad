@extends('layouts.app')

@section('title', 'Edit club')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
    <li class="breadcrumb-item"><a href="{{ route('clubs.index') }}">Clubs</a></li>
    <li class="breadcrumb-item"><a href="{{ route('clubs.show', $club) }}">{{ $club->name }}</a></li>
    <li class="breadcrumb-item active" aria-current="page">Edit</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h2 class="card-title h6 mb-0">Club details</h2>
                </div>

                <form action="{{ route('clubs.update', $club) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="card-body">
                        @include('clubs._form', ['club' => $club, 'inscritos' => $inscritos])
                    </div>

                    <div class="card-footer bg-white">
                        <button type="submit" class="btn btn-primary">Save changes</button>
                        <a href="{{ route('clubs.show', $club) }}" class="btn btn-outline-secondary">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
