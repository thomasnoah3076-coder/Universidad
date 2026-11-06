@extends('layouts.app')

@section('title', 'Students')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
    <li class="breadcrumb-item active" aria-current="page">Students</li>
@endsection

@section('page-actions')
    <a href="{{ route('students.create') }}" class="btn btn-primary">
        <i class="fas fa-plus mr-1"></i>New student
    </a>
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <h2 class="card-title h6 mb-0">
                {{ $students->total() }} {{ $students->total() === 1 ? 'registered student' : 'registered students' }}
            </h2>
        </div>

        @if ($students->isEmpty())
            <div class="card-body empty-state text-center py-5">
                <i class="fas fa-user-graduate empty-state-icon" aria-hidden="true"></i>
                <p class="mb-3">No students registered yet.</p>
                <a href="{{ route('students.create') }}" class="btn btn-primary">Register the first one</a>
            </div>
        @else
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th scope="col">Student</th>
                            <th scope="col" class="d-none d-md-table-cell">Program</th>
                            <th scope="col" class="d-none d-md-table-cell">Registered</th>
                            <th scope="col" class="d-none d-md-table-cell text-center">Clubs</th>
                            <th scope="col" class="text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($students as $student)
                            <tr>
                                <td>
                                    <a href="{{ route('students.show', $student) }}" class="font-weight-bold">
                                        {{ $student->first_name }} {{ $student->last_name }}
                                    </a>
                                    <span class="d-block small text-muted">{{ $student->email }}</span>
                                </td>
                                <td class="d-none d-md-table-cell">{{ $student->degree_program ?? 'No program' }}</td>
                                <td class="d-none d-md-table-cell">
                                    {{ $student->registration_date
                                        ? \Illuminate\Support\Carbon::parse($student->registration_date)->format('d/m/Y')
                                        : 'No date' }}
                                </td>
                                <td class="d-none d-md-table-cell text-center">{{ $student->enrollments_count }}</td>
                                <td class="text-right text-nowrap">
                                    <a href="{{ route('students.show', $student) }}" class="btn btn-sm btn-outline-secondary"
                                        title="View details" aria-label="View details for {{ $student->first_name }} {{ $student->last_name }}">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('students.edit', $student) }}" class="btn btn-sm btn-outline-secondary"
                                        title="Edit" aria-label="Edit {{ $student->first_name }} {{ $student->last_name }}">
                                        <i class="fas fa-pen"></i>
                                    </a>
                                    <form action="{{ route('students.destroy', $student) }}" method="POST" class="d-inline"
                                        data-confirm="Delete {{ $student->first_name }} {{ $student->last_name }}? Their enrollments will also be deleted.">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete"
                                            aria-label="Delete {{ $student->first_name }} {{ $student->last_name }}">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            @if ($students->hasPages())
                <div class="card-footer bg-white">
                    {{ $students->links('pagination::bootstrap-4') }}
                </div>
            @endif
        @endif
    </div>
@endsection
