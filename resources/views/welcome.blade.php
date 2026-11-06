@extends('layouts.app_authentication')

@section('title', 'Welcome')

@section('body-class', 'login-page login-split')

@section('content')
    <div class="login-split">
        @include('layouts.partials.auth-ledger')

        <main class="login-panel">
            <div class="login-box">
                <div class="login-panel-head">
                    <h2 class="login-title">Welcome</h2>
                    <p class="login-subtitle">
                        Sign in to the academic registry or create an account to get started.
                    </p>
                </div>

                <a href="{{ route('login') }}" class="btn btn-primary btn-block btn-login">
                    Sign in
                </a>
                <a href="{{ route('register') }}" class="btn btn-outline-secondary btn-block btn-login mt-2">
                    Create account
                </a>

                <p class="login-help">
                    Access for students, faculty and registry staff.
                </p>
            </div>
        </main>
    </div>
@endsection
