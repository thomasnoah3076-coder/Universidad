<div class="form-group">
    <label for="estudiantes">Students</label>
    <select name="estudiantes[]" id="estudiantes"
        class="form-control @error('estudiantes') is-invalid @enderror"
        data-placeholder="Select students" multiple required>
        @foreach ($students as $student)
            <option value="{{ $student->id }}"
                @selected(in_array($student->id, array_map('intval', (array) old('estudiantes', [])), true))>
                {{ $student->last_name }}, {{ $student->first_name }}
                — {{ $student->numerodocumento ?? 'No document' }}
            </option>
        @endforeach
    </select>
    @error('estudiantes')
        <span class="invalid-feedback d-block" role="alert"><strong>{{ $message }}</strong></span>
    @enderror
    @error('estudiantes.*')
        <span class="invalid-feedback d-block" role="alert"><strong>{{ $message }}</strong></span>
    @enderror
    <small class="form-text">You can select more than one; hold Ctrl (or Cmd) to choose multiple.</small>
</div>

<div class="form-group mb-0">
    <label for="clubes">Clubs</label>
    <select name="clubes[]" id="clubes"
        class="form-control @error('clubes') is-invalid @enderror"
        data-placeholder="Select clubs" multiple required>
        @foreach ($clubs as $club)
            <option value="{{ $club->id }}"
                @selected(in_array($club->id, array_map('intval', (array) old('clubes', [])), true))>
                {{ $club->name }}
            </option>
        @endforeach
    </select>
    @error('clubes')
        <span class="invalid-feedback d-block" role="alert"><strong>{{ $message }}</strong></span>
    @enderror
    @error('clubes.*')
        <span class="invalid-feedback d-block" role="alert"><strong>{{ $message }}</strong></span>
    @enderror
    <small class="form-text">Only active clubs are shown.</small>
</div>
