@extends('layouts.app_authentication')

@section('title', 'Confirmar contraseña')

@section('body-class', 'login-page login-split')

@section('content')
    <div class="login-split">
        @include('layouts.partials.auth-ledger')

        <main class="login-panel">
            <div class="login-box">
                <div class="login-panel-head">
                    <h2 class="login-title">Confirma tu contraseña</h2>
                    <p class="login-subtitle">
                        Por seguridad, vuelve a introducir tu contraseña para continuar.
                    </p>
                </div>

                <form method="POST" action="{{ route('password.confirm') }}">
                    @csrf

                    <div class="form-group">
                        <label for="password">Contraseña</label>
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
                            name="password" required autocomplete="current-password" autofocus>
                        @error('password')
                            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary btn-block btn-login">Confirmar</button>
                </form>

                <p class="login-help">
                    <a href="{{ route('home') }}">Volver al inicio</a>
                </p>
            </div>
        </main>
    </div>
@endsection
