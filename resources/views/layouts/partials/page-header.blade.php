@hasSection('title')
    <section class="content-header">
        <div class="container-fluid">
            <div class="d-flex flex-wrap align-items-center justify-content-between">
                <div class="page-heading">
                    <h1 class="page-title">@yield('title')</h1>

                    <nav aria-label="Ruta de navegación">
                        <ol class="breadcrumb page-breadcrumb">
                            @yield('breadcrumbs')
                        </ol>
                    </nav>
                </div>

                @hasSection('page-actions')
                    <div class="page-actions">
                        @yield('page-actions')
                    </div>
                @endif
            </div>
        </div>
    </section>
@endif
