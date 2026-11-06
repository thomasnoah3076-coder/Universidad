@extends('layouts.app')

@section('title', 'Home')

@section('breadcrumbs')
    <li class="breadcrumb-item active" aria-current="page">Home</li>
@endsection

@section('page-actions')
    <a href="{{ route('students.create') }}" class="btn btn-outline-secondary">
        <i class="fas fa-user-plus mr-1"></i>New student
    </a>
    <a href="{{ route('clubs.create') }}" class="btn btn-primary">
        <i class="fas fa-plus mr-1"></i>New club
    </a>
@endsection

@section('content')
    <section class="ledger" aria-labelledby="ledger-title">
        <div class="ledger-masthead">
            <div>
                <h2 id="ledger-title" class="ledger-title">Registry summary</h2>
                <p class="ledger-subtitle">Registered students, clubs and enrollments.</p>
            </div>
            <span class="ledger-date">{{ now()->format('d/m/Y') }}</span>
        </div>

        <div class="ledger-figures">
            <div class="ledger-figure">
                <span class="ledger-label">Students</span>
                <span class="ledger-number">{{ number_format($totalEstudiantes) }}</span>
                <a href="{{ route('students.index') }}" class="ledger-link">View students</a>
            </div>

            <div class="ledger-figure">
                <span class="ledger-label">Clubs</span>
                <span class="ledger-number">{{ number_format($totalClubes) }}</span>
                <a href="{{ route('clubs.index') }}" class="ledger-link">View clubs</a>
            </div>

            <div class="ledger-figure">
                <span class="ledger-label">Enrollments</span>
                <span class="ledger-number">{{ number_format($totalInscripciones) }}</span>
                <span class="ledger-note">{{ number_format($inscripcionesActivas) }} active</span>
            </div>
        </div>
    </section>

    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h2 class="card-title">How to use the registry</h2>
                </div>
                <div class="card-body">
                    <ol class="mb-0 pl-3">
                        <li class="mb-2">Register students with their email and degree program.</li>
                        <li class="mb-2">Create a club and choose its president.</li>
                        <li>In the club form, select the students you want to enroll.</li>
                    </ol>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h2 class="card-title">Quick links</h2>
                </div>
                <div class="list-group list-group-flush">
                    <a href="{{ route('students.index') }}" class="list-group-item list-group-item-action">
                        <i class="fas fa-user-graduate mr-2 text-muted"></i>Student list
                    </a>
                    <a href="{{ route('clubs.index') }}" class="list-group-item list-group-item-action">
                        <i class="fas fa-users mr-2 text-muted"></i>Club list
                    </a>
                    <a href="{{ route('settings') }}" class="list-group-item list-group-item-action">
                        <i class="fas fa-cog mr-2 text-muted"></i>Settings
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
