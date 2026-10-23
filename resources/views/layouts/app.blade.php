<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Inicio') · Universidad</title>

    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">

    <!-- Font Awesome (local) -->
    <link rel="stylesheet" href="{{ asset('backend/plugins/fontawesome-free/css/all.min.css') }}">
    <!-- AdminLTE 3 / Bootstrap 4 (local) -->
    <link rel="stylesheet" href="{{ asset('backend/dist/css/adminlte.min.css') }}">
    <!-- Tema del proyecto -->
    <link rel="stylesheet" href="{{ asset('css/universidad.css') }}">

    @stack('css')
</head>

<body class="hold-transition sidebar-mini layout-fixed layout-footer-fixed">
@php($nombreProyecto = 'Universidad')

<div class="wrapper">
    @include('layouts.partials.topbar', ['nombreProyecto' => $nombreProyecto])
    @include('layouts.partials.sidebar', ['nombreProyecto' => $nombreProyecto])

    <div class="content-wrapper">
        @include('layouts.partials.page-header')

        <section class="content">
            <div class="container-fluid">
                @include('layouts.partials.alerts')
                @yield('content')
            </div>
        </section>
    </div>

    @include('layouts.partials.footer', ['nombreProyecto' => $nombreProyecto])
</div>

<!-- jQuery (local) -->
<script src="{{ asset('backend/plugins/jquery/jquery.min.js') }}"></script>
<!-- Bootstrap 4 (local) -->
<script src="{{ asset('backend/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- AdminLTE App (local) -->
<script src="{{ asset('backend/dist/js/adminlte.min.js') }}"></script>
<!-- Confirmación de borrado -->
<script src="{{ asset('js/universidad.js') }}"></script>

@stack('scripts')
</body>
</html>
