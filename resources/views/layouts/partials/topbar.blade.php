<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"
                aria-label="Mostrar u ocultar el menú">
                <i class="fas fa-bars"></i>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('home') }}" class="nav-link topbar-project">{{ $nombreProyecto }}</a>
        </li>
    </ul>

    <ul class="navbar-nav ml-auto align-items-center">
        @auth
            <li class="nav-item d-none d-md-block mr-3">
                <span class="topbar-user">{{ Auth::user()->name }}</span>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('logout') }}"
                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                    title="Cerrar sesión" aria-label="Cerrar sesión">
                    <i class="fas fa-power-off"></i>
                </a>
                <form id="logout-form" method="POST" action="{{ route('logout') }}" class="d-none">
                    @csrf
                </form>
            </li>
        @endauth
    </ul>
</nav>
