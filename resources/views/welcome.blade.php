@extends('layouts.app_authentication')

@section('title', 'Bienvenido')

@section('body-class', 'login-page login-split')

@section('content')
    <div class="login-split">
        @include('layouts.partials.auth-ledger')

        <main class="login-panel">
            <div class="login-box">
                <div class="login-panel-head">
                    <h2 class="login-title">Bienvenido</h2>
                    <p class="login-subtitle">
                        Accede al registro académico o crea una cuenta para comenzar.
                    </p>
                </div>

                <a href="{{ route('login') }}" class="btn btn-primary btn-block btn-login">
                    Iniciar sesión
                </a>
                <a href="{{ route('register') }}" class="btn btn-outline-secondary btn-block btn-login mt-2">
                    Crear cuenta
                </a>

                <p class="login-help">
                    Acceso para estudiantes, docentes y personal del registro.
                </p>
            </div>
        </main>
    </div>
@endsection
