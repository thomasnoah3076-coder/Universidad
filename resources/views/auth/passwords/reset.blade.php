@extends('layouts.app_authentication')

@section('title', 'Nueva contraseña')

@section('body-class', 'login-page login-standalone')

@section('content')
    <div class="login-box">
        <div class="login-standalone-brand">
            <span class="brand-mark" aria-hidden="true">U</span>
            <span>Universidad</span>
        </div>

        <div class="card">
            <div class="card-body">
                <h1 class="login-title">Nueva contraseña</h1>
                <p class="login-subtitle mb-4">
                    Define una contraseña para tu cuenta.
                </p>

                <form action="{{ route('password.update') }}" method="POST">
                    @csrf
                    <input type="hidden" name="token" value="{{ $token }}">

                    <div class="form-group">
                        <label for="email">Correo electrónico</label>
                        <input id="email" type="email" name="email"
                            class="form-control @error('email') is-invalid @enderror"
                            value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus>
                        @error('email')
                            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="password">Contraseña</label>
                        <input id="password" type="password" name="password"
                            class="form-control @error('password') is-invalid @enderror" required
                            autocomplete="new-password">
                        @error('password')
                            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="password-confirm">Confirmar contraseña</label>
                        <input id="password-confirm" type="password" class="form-control"
                            name="password_confirmation" required autocomplete="new-password">
                    </div>

                    <button type="submit" class="btn btn-primary btn-block">Guardar contraseña</button>
                </form>

                <p class="login-help">
                    <a href="{{ route('login') }}">Volver al inicio de sesión</a>
                </p>
            </div>
        </div>
    </div>
@endsection
