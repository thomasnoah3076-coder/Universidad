@php($club = $club ?? null)

<div class="form-group">
    <label for="name">Nombre del club</label>
    <input type="text" name="name" id="name"
        class="form-control @error('name') is-invalid @enderror"
        value="{{ old('name', $club->name ?? '') }}" required>
    @error('name')
        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
    @enderror
</div>

<div class="form-group">
    <label for="description">Descripción</label>
    <textarea name="description" id="description" rows="4"
        class="form-control @error('description') is-invalid @enderror"
        placeholder="Actividades, objetivo o público del club">{{ old('description', $club->description ?? '') }}</textarea>
    @error('description')
        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
    @enderror
    <small class="form-text">Opcional.</small>
</div>

<div class="form-row">
    <div class="form-group col-md-6">
        <label for="foundation_date">Fecha de fundación</label>
        <input type="date" name="foundation_date" id="foundation_date"
            class="form-control @error('foundation_date') is-invalid @enderror"
            value="{{ old('foundation_date', $club->foundation_date ?? '') }}">
        @error('foundation_date')
            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
        @enderror
        <small class="form-text">Opcional.</small>
    </div>

    <div class="form-group col-md-6">
        <label for="president_id">Presidente</label>
        <select name="president_id" id="president_id"
            class="form-control @error('president_id') is-invalid @enderror">
            <option value="">Sin presidente</option>
            @foreach ($students as $student)
                <option value="{{ $student->id }}" @selected((string) old('president_id', $club->president_id ?? '') === (string) $student->id)>
                    {{ $student->last_name }}, {{ $student->first_name }}
                </option>
            @endforeach
        </select>
        @error('president_id')
            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
        @enderror
    </div>
</div>

<div class="form-group mb-0">
    <label for="students">Estudiantes inscritos</label>
    <select name="students[]" id="students" class="form-control select-estudiantes" multiple>
        @foreach ($students as $student)
            <option value="{{ $student->id }}"
                @selected(in_array($student->id, array_map('intval', (array) old('students', $inscritos ?? [])), true))>
                {{ $student->last_name }}, {{ $student->first_name }}
            </option>
        @endforeach
    </select>
    @error('students')
        <span class="invalid-feedback d-block" role="alert"><strong>{{ $message }}</strong></span>
    @enderror
    @error('students.*')
        <span class="invalid-feedback d-block" role="alert"><strong>{{ $message }}</strong></span>
    @enderror
</div>

@push('css')
    <link rel="stylesheet" href="{{ asset('backend/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
@endpush

@push('scripts')
    <script src="{{ asset('backend/plugins/select2/js/select2.full.min.js') }}"></script>
    <script>
        $(function () {
            $('.select-estudiantes').select2({
                theme: 'bootstrap4',
                width: '100%',
                placeholder: 'Selecciona estudiantes',
                language: {
                    noResults: function () {
                        return 'Sin resultados';
                    }
                }
            });
        });
    </script>
@endpush
