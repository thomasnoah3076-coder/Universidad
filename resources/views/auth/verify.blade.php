@extends('layouts.app_authentication')

@section('title', 'Verify email')

@section('body-class', 'login-page login-standalone')

@section('content')
    <div class="login-box">
        <div class="login-standalone-brand">
            <span class="brand-mark" aria-hidden="true">U</span>
            <span>Universidad</span>
        </div>

        <div class="card">
            <div class="card-body">
                <h1 class="login-title">Verify your email</h1>
                <p class="login-subtitle mb-4">
                    Before continuing, check your email and open the verification link.
                </p>

                @if (session('resent'))
                    <div class="alert alert-success" role="alert">
                        We sent you a new verification link.
                    </div>
                @endif

                @if (Route::has('verification.resend'))
                    <form method="POST" action="{{ route('verification.resend') }}">
                        @csrf
                        <p class="mb-3">If you did not receive the email, we can send another one.</p>
                        <button type="submit" class="btn btn-primary btn-block">Send another link</button>
                    </form>
                @endif

                <p class="login-help">
                    <a href="{{ route('home') }}">Back to home</a>
                </p>
            </div>
        </div>
    </div>
@endsection
