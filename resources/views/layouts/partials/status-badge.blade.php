@php
    $estados = [
        'pending' => ['Pendiente', 'badge-warning'],
        'active' => ['Activo', 'badge-success'],
        'rejected' => ['Rechazado', 'badge-danger'],
        'inactive' => ['Inactivo', 'badge-secondary'],
    ];

    [$textoEstado, $claseEstado] = $estados[$status] ?? [$status, 'badge-secondary'];
@endphp

<span class="badge {{ $claseEstado }}">{{ $textoEstado }}</span>
