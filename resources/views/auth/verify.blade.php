@extends('layouts.app_authentication')

@section('title', 'Verificar correo')

@section('body-class', 'login-page login-standalone')

@section('content')
    <div class="login-box">
        <div class="login-standalone-brand">
            <span class="brand-mark" aria-hidden="true">U</span>
            <span>Universidad</span>
        </div>

        <div class="card">
            <div class="card-body">
                <h1 class="login-title">Verifica tu correo</h1>
                <p class="login-subtitle mb-4">
                    Antes de continuar, revisa tu correo y abre el enlace de verificación.
                </p>

                @if (session('resent'))
                    <div class="alert alert-success" role="alert">
                        Te enviamos un nuevo enlace de verificación.
                    </div>
                @endif

                @if (Route::has('verification.resend'))
                    <form method="POST" action="{{ route('verification.resend') }}">
                        @csrf
                        <p class="mb-3">Si no recibiste el correo, podemos enviarte otro.</p>
                        <button type="submit" class="btn btn-primary btn-block">Enviar otro enlace</button>
                    </form>
                @endif

                <p class="login-help">
                    <a href="{{ route('home') }}">Volver al inicio</a>
                </p>
            </div>
        </div>
    </div>
@endsection
