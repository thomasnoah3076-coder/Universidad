@extends('layouts.app')

@section('title', 'Clubs')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
    <li class="breadcrumb-item active" aria-current="page">Clubs</li>
@endsection

@section('page-actions')
    <a href="{{ route('clubs.create') }}" class="btn btn-primary">
        <i class="fas fa-plus mr-1"></i>New club
    </a>
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <h2 class="card-title h6 mb-0">
                {{ $clubs->total() }} {{ $clubs->total() === 1 ? 'registered club' : 'registered clubs' }}
            </h2>
        </div>

        @if ($clubs->isEmpty())
            <div class="card-body empty-state text-center py-5">
                <i class="fas fa-users empty-state-icon" aria-hidden="true"></i>
                <p class="mb-3">No clubs registered yet.</p>
                <a href="{{ route('clubs.create') }}" class="btn btn-primary">Create the first one</a>
            </div>
        @else
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th scope="col">Club</th>
                            <th scope="col" class="d-none d-md-table-cell">President</th>
                            <th scope="col" class="d-none d-md-table-cell">Founded</th>
                            <th scope="col" class="d-none d-md-table-cell text-center">Enrolled</th>
                            <th scope="col" class="d-none d-md-table-cell">Status</th>
                            <th scope="col" class="text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($clubs as $club)
                            <tr>
                                <td>
                                    <a href="{{ route('clubs.show', $club) }}" class="font-weight-bold">{{ $club->name }}</a>
                                    @if ($club->description)
                                        <span class="d-block small text-muted">
                                            {{ \Illuminate\Support\Str::limit($club->description, 70) }}
                                        </span>
                                    @endif
                                </td>
                                <td class="d-none d-md-table-cell">
                                    @if ($club->president)
                                        <a href="{{ route('students.show', $club->president) }}">
                                            {{ $club->president->first_name }} {{ $club->president->last_name }}
                                        </a>
                                    @else
                                        <span class="text-muted">No president</span>
                                    @endif
                                </td>
                                <td class="d-none d-md-table-cell">
                                    {{ $club->foundation_date
                                        ? \Illuminate\Support\Carbon::parse($club->foundation_date)->format('d/m/Y')
                                        : 'No date' }}
                                </td>
                                <td class="d-none d-md-table-cell text-center">{{ $club->enrollments_count }}</td>
                                <td class="d-none d-md-table-cell">
                                    <span class="badge {{ $club->status ? 'badge-success' : 'badge-secondary' }}">
                                        {{ $club->status ? 'Active' : 'Inactive' }}
                                    </span>
                                </td>
                                <td class="text-right text-nowrap">
                                    <a href="{{ route('clubs.show', $club) }}" class="btn btn-sm btn-outline-secondary"
                                        title="View details" aria-label="View details for {{ $club->name }}">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('clubs.edit', $club) }}" class="btn btn-sm btn-outline-secondary"
                                        title="Edit" aria-label="Edit {{ $club->name }}">
                                        <i class="fas fa-pen"></i>
                                    </a>
                                    <form action="{{ route('clubs.destroy', $club) }}" method="POST" class="d-inline"
                                        data-confirm="Delete the club {{ $club->name }}? Its enrollments will also be deleted.">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete"
                                            aria-label="Delete {{ $club->name }}">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            @if ($clubs->hasPages())
                <div class="card-footer bg-white">
                    {{ $clubs->links('pagination::bootstrap-4') }}
                </div>
            @endif
        @endif
    </div>
@endsection
