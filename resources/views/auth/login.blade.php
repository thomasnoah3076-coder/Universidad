@extends('layouts.app_authentication')

@section('title', 'Iniciar sesión')

@section('body-class', 'login-page login-split')

@section('content')
    <div class="login-split">
        @include('layouts.partials.auth-ledger')

        <main class="login-panel">
            <div class="login-box">
                <div class="login-panel-head">
                    <h2 class="login-title">Iniciar sesión</h2>
                    <p class="login-subtitle">Accede con tu cuenta institucional.</p>
                </div>

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="form-group">
                        <label for="email">Correo electrónico</label>
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                            name="email" value="{{ old('email') }}" required autocomplete="email" autofocus
                            placeholder="nombre@universidad.edu">
                        @error('email')
                            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <div class="d-flex justify-content-between align-items-baseline">
                            <label for="password">Contraseña</label>
                            @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}" class="small">¿Olvidaste tu contraseña?</a>
                            @endif
                        </div>
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
                            name="password" required autocomplete="current-password" placeholder="Tu contraseña">
                        @error('password')
                            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>

                    <div class="custom-control custom-checkbox mb-4">
                        <input type="checkbox" class="custom-control-input" id="remember" name="remember"
                            {{ old('remember') ? 'checked' : '' }}>
                        <label class="custom-control-label" for="remember">Recordarme en este equipo</label>
                    </div>

                    <button type="submit" class="btn btn-primary btn-block btn-login">Entrar</button>
                </form>

                <p class="login-help">
                    Solo personal autorizado. Si no puedes entrar, contacta a la oficina de registro.
                </p>
            </div>
        </main>
    </div>
@endsection
