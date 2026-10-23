@extends('layouts.app_authentication')

@section('title', 'Restablecer contraseña')

@section('body-class', 'login-page login-standalone')

@section('content')
    <div class="login-box">
        <div class="login-standalone-brand">
            <span class="brand-mark" aria-hidden="true">U</span>
            <span>Universidad</span>
        </div>

        <div class="card">
            <div class="card-body">
                <h1 class="login-title">Restablecer contraseña</h1>
                <p class="login-subtitle mb-4">
                    Escribe tu correo y te enviaremos un enlace para crear una contraseña nueva.
                </p>

                @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif

                <form action="{{ route('password.email') }}" method="POST">
                    @csrf

                    <div class="form-group">
                        <label for="email">Correo electrónico</label>
                        <input id="email" type="email" name="email"
                            class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}"
                            placeholder="nombre@universidad.edu" required autocomplete="email" autofocus>
                        @error('email')
                            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary btn-block">Enviar enlace</button>
                </form>

                <p class="login-help">
                    <a href="{{ route('login') }}">Volver al inicio de sesión</a>
                </p>
            </div>
        </div>
    </div>
@endsection
