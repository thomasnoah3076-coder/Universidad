@php
    $estados = [
        'pending' => ['Pending', 'badge-warning'],
        'active' => ['Active', 'badge-success'],
        'rejected' => ['Rejected', 'badge-danger'],
        'inactive' => ['Inactive', 'badge-secondary'],
    ];

    [$textoEstado, $claseEstado] = $estados[$status] ?? [$status, 'badge-secondary'];
@endphp

<span class="badge {{ $claseEstado }}">{{ $textoEstado }}</span>
