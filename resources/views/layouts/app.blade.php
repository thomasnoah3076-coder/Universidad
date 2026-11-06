<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Home') · Universidad</title>

    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">

    <!-- Font Awesome (local) -->
    <link rel="stylesheet" href="{{ asset('backend/plugins/fontawesome-free/css/all.min.css') }}">
    <!-- AdminLTE 3 / Bootstrap 4 (local) -->
    <link rel="stylesheet" href="{{ asset('backend/dist/css/adminlte.min.css') }}">
    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('backend/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <!-- Select2 -->
    <link rel="stylesheet" href="{{ asset('backend/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/dist/css/select2.css') }}">
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
<!-- DataTables (local) -->
<script src="{{ asset('backend/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('backend/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('backend/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('backend/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
<!-- DataTables: inicialización de #example1 -->
<script src="{{ asset('backend/dist/js/table.js') }}"></script>
<!-- Select2 (local) -->
<script src="{{ asset('backend/dist/js/select2.js') }}"></script>
<!-- Select2: inicialización por id -->
<script src="{{ asset('backend/dist/js/selectors.js') }}"></script>
<!-- Confirmación de borrado -->
<script src="{{ asset('js/universidad.js') }}"></script>

@stack('scripts')
</body>
</html>
