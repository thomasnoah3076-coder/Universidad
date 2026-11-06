@extends('layouts.app')

@section('title', 'New club')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
    <li class="breadcrumb-item"><a href="{{ route('clubs.index') }}">Clubs</a></li>
    <li class="breadcrumb-item active" aria-current="page">New</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h2 class="card-title h6 mb-0">Club details</h2>
                </div>

                <form action="{{ route('clubs.store') }}" method="POST">
                    @csrf

                    <div class="card-body">
                        @include('clubs._form')
                    </div>

                    <div class="card-footer bg-white">
                        <button type="submit" class="btn btn-primary">Save club</button>
                        <a href="{{ route('clubs.index') }}" class="btn btn-outline-secondary">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
