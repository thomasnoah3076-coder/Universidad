<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <a href="{{ route('home') }}" class="brand-link">
        <span class="brand-mark" aria-hidden="true">U</span>
        <span class="brand-text">{{ $nombreProyecto }}</span>
    </a>

    <div class="sidebar">
        <nav class="mt-3" aria-label="Menú principal">
            <ul class="nav nav-pills nav-sidebar flex-column" role="menu">
                <li class="nav-item">
                    <a href="{{ route('home') }}" class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-home"></i>
                        <p>Inicio</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('students.index') }}"
                        class="nav-link {{ request()->routeIs('students.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-user-graduate"></i>
                        <p>Estudiantes</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('clubs.index') }}"
                        class="nav-link {{ request()->routeIs('clubs.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-users"></i>
                        <p>Clubes</p>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</aside>
