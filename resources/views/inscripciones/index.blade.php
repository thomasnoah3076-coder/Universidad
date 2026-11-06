@extends('layouts.app')

@section('title', 'Enrollments')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
    <li class="breadcrumb-item active" aria-current="page">Enrollments</li>
@endsection

@section('page-actions')
    <a href="{{ route('inscripciones.create') }}" class="btn btn-primary">
        <i class="fas fa-plus mr-1"></i>New enrollment
    </a>
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <h2 class="card-title h6 mb-0">
                {{ $clubs->count() }} active {{ $clubs->count() === 1 ? 'club' : 'clubs' }}
            </h2>
        </div>

        <div class="table-responsive">
            <table id="example1" class="table club-table mb-0" data-ordering="false" data-responsive="false">
                <thead>
                    <tr>
                        <th scope="col" class="d-none">Clubs and enrolled students</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($clubs as $club)
                        <tr>
                            <td>
                                <div class="club-box">
                                    <div class="club-box-header">
                                        <a href="{{ route('clubs.show', $club) }}">{{ $club->name }}</a>
                                        <span class="badge badge-light border">
                                            {{ $club->estudiantes_count }} enrolled
                                        </span>
                                    </div>

                                    @if ($club->estudiantes->isEmpty())
                                        <p class="club-box-empty mb-0">No students yet</p>
                                    @else
                                        <div class="table-responsive">
                                            <table class="table table-hover club-students mb-0">
                                                <thead>
                                                    <tr>
                                                        <th scope="col">Student</th>
                                                        <th scope="col">Document</th>
                                                        <th scope="col" class="d-none d-md-table-cell">Email</th>
                                                        <th scope="col" class="d-none d-md-table-cell">Program</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($club->estudiantes as $estudiante)
                                                        <tr>
                                                            <td>
                                                                <a href="{{ route('students.show', $estudiante) }}" class="font-weight-bold">
                                                                    {{ $estudiante->first_name }} {{ $estudiante->last_name }}
                                                                </a>
                                                            </td>
                                                            <td>{{ $estudiante->numerodocumento ?? 'No document' }}</td>
                                                            <td class="d-none d-md-table-cell">{{ $estudiante->email }}</td>
                                                            <td class="d-none d-md-table-cell">{{ $estudiante->degree_program ?? 'No program' }}</td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
