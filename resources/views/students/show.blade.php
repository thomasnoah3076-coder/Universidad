@extends('layouts.app')

@section('title', 'Student details')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
    <li class="breadcrumb-item"><a href="{{ route('students.index') }}">Students</a></li>
    <li class="breadcrumb-item active" aria-current="page">{{ $student->first_name }} {{ $student->last_name }}</li>
@endsection

@section('page-actions')
    <a href="{{ route('students.edit', $student) }}" class="btn btn-primary">
        <i class="fas fa-pen mr-1"></i>Edit
    </a>
    <a href="{{ route('students.index') }}" class="btn btn-outline-secondary">Back to list</a>
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-5">
            <div class="card">
                <div class="card-header">
                    <h2 class="card-title h6 mb-0">{{ $student->first_name }} {{ $student->last_name }}</h2>
                </div>
                <div class="card-body">
                    @if (! empty($student->image))
                        <img src="{{ asset($student->image) }}" alt="Photo of {{ $student->first_name }} {{ $student->last_name }}"
                            class="img-fluid rounded mb-3" style="max-height: 220px; object-fit: cover;">
                    @endif

                    <dl class="row mb-0">
                        <dt class="col-sm-5">Email</dt>
                        <dd class="col-sm-7">{{ $student->email }}</dd>

                        <dt class="col-sm-5">Document</dt>
                        <dd class="col-sm-7">{{ $student->numerodocumento ?? 'Not registered' }}</dd>

                        <dt class="col-sm-5">Date of birth</dt>
                        <dd class="col-sm-7">
                            {{ $student->date_of_birth
                                ? \Illuminate\Support\Carbon::parse($student->date_of_birth)->format('d/m/Y')
                                : 'Not registered' }}
                        </dd>

                        <dt class="col-sm-5">Program</dt>
                        <dd class="col-sm-7">{{ $student->degree_program ?? 'No program' }}</dd>

                        <dt class="col-sm-5">Registration date</dt>
                        <dd class="col-sm-7 mb-0">
                            {{ $student->registration_date
                                ? \Illuminate\Support\Carbon::parse($student->registration_date)->format('d/m/Y')
                                : 'Not registered' }}
                        </dd>
                    </dl>
                </div>
            </div>
        </div>

        <div class="col-lg-7">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h2 class="card-title h6 mb-0">Enrolled clubs</h2>
                    <span class="text-muted small">{{ $student->enrollments->count() }}</span>
                </div>

                @if ($student->enrollments->isEmpty())
                    <div class="card-body text-center py-5">
                        <i class="fas fa-users empty-state-icon" aria-hidden="true"></i>
                        <p class="mb-0">This student is not enrolled in any club yet.</p>
                    </div>
                @else
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr>
                                    <th scope="col">Club</th>
                                    <th scope="col">Enrollment date</th>
                                    <th scope="col">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($student->enrollments as $inscripcion)
                                    <tr>
                                        <td>
                                            <a href="{{ route('clubs.show', $inscripcion->club) }}" class="font-weight-bold">
                                                {{ $inscripcion->club->name }}
                                            </a>
                                        </td>
                                        <td>
                                            {{ $inscripcion->enrollment_date
                                                ? \Illuminate\Support\Carbon::parse($inscripcion->enrollment_date)->format('d/m/Y')
                                                : 'No date' }}
                                        </td>
                                        <td>@include('layouts.partials.status-badge', ['status' => $inscripcion->status])</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
