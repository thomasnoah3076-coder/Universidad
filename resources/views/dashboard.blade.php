@extends('layouts.app')

@section('title', 'Dashboard')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
    <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
@endsection

@section('page-actions')
    <a href="{{ route('students.index') }}" class="btn btn-outline-secondary">
        <i class="fas fa-user-graduate mr-1"></i>Students
    </a>
    <a href="{{ route('clubs.index') }}" class="btn btn-primary">
        <i class="fas fa-users mr-1"></i>Clubs
    </a>
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h2 class="card-title">Administration dashboard</h2>
                </div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <p class="mb-4">
                        From this dashboard you can review the academic registry and manage students and clubs.
                    </p>

                    <a href="{{ route('students.index') }}" class="btn btn-primary mr-2 mb-2">View students</a>
                    <a href="{{ route('clubs.index') }}" class="btn btn-outline-secondary mr-2 mb-2">View clubs</a>
                    <a href="{{ route('settings') }}" class="btn btn-outline-secondary mb-2">Settings</a>
                </div>
            </div>
        </div>
    </div>
@endsection
