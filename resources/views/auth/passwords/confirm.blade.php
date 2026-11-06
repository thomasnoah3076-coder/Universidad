@extends('layouts.app_authentication')

@section('title', 'Confirm password')

@section('body-class', 'login-page login-split')

@section('content')
    <div class="login-split">
        @include('layouts.partials.auth-ledger')

        <main class="login-panel">
            <div class="login-box">
                <div class="login-panel-head">
                    <h2 class="login-title">Confirm your password</h2>
                    <p class="login-subtitle">
                        For security, enter your password again to continue.
                    </p>
                </div>

                <form method="POST" action="{{ route('password.confirm') }}">
                    @csrf

                    <div class="form-group">
                        <label for="password">Password</label>
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
                            name="password" required autocomplete="current-password" autofocus>
                        @error('password')
                            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary btn-block btn-login">Confirm</button>
                </form>

                <p class="login-help">
                    <a href="{{ route('home') }}">Back to home</a>
                </p>
            </div>
        </main>
    </div>
@endsection
