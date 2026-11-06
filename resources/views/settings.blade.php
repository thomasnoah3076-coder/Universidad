@extends('layouts.app')

@section('title', 'Settings')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
    <li class="breadcrumb-item active" aria-current="page">Settings</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h2 class="card-title">Application preferences</h2>
                </div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <dl class="row mb-4">
                        <dt class="col-sm-4">Application</dt>
                        <dd class="col-sm-8">Universidad</dd>

                        <dt class="col-sm-4">Registry</dt>
                        <dd class="col-sm-8">Students, clubs and enrollments</dd>

                        <dt class="col-sm-4">Technology</dt>
                        <dd class="col-sm-8">Laravel 13 with AdminLTE 3</dd>
                    </dl>

                    <p class="text-muted mb-4">
                        There are no editable preferences in this version yet.
                    </p>

                    <a href="{{ route('home') }}" class="btn btn-primary">Back to home</a>
                </div>
            </div>
        </div>
    </div>
@endsection
