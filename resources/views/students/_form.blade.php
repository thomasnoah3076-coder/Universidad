@php($student = $student ?? null)

<div class="form-row">
    <div class="form-group col-md-6">
        <label for="first_name">Nombre</label>
        <input type="text" name="first_name" id="first_name"
            class="form-control @error('first_name') is-invalid @enderror"
            value="{{ old('first_name', $student->first_name ?? '') }}" required>
        @error('first_name')
            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
        @enderror
    </div>

    <div class="form-group col-md-6">
        <label for="last_name">Apellido</label>
        <input type="text" name="last_name" id="last_name"
            class="form-control @error('last_name') is-invalid @enderror"
            value="{{ old('last_name', $student->last_name ?? '') }}" required>
        @error('last_name')
            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
        @enderror
    </div>
</div>

<div class="form-group">
    <label for="email">Correo electrónico</label>
    <input type="email" name="email" id="email"
        class="form-control @error('email') is-invalid @enderror"
        value="{{ old('email', $student->email ?? '') }}" required>
    @error('email')
        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
    @enderror
</div>

<div class="form-row">
    <div class="form-group col-md-6">
        <label for="date_of_birth">Fecha de nacimiento</label>
        <input type="date" name="date_of_birth" id="date_of_birth"
            class="form-control @error('date_of_birth') is-invalid @enderror"
            value="{{ old('date_of_birth', $student->date_of_birth ?? '') }}">
        @error('date_of_birth')
            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
        @enderror
        <small class="form-text">Opcional.</small>
    </div>

    <div class="form-group col-md-6">
        <label for="registration_date">Fecha de registro</label>
        <input type="date" name="registration_date" id="registration_date"
            class="form-control @error('registration_date') is-invalid @enderror"
            value="{{ old('registration_date', $student->registration_date ?? '') }}">
        @error('registration_date')
            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
        @enderror
        <small class="form-text">Opcional.</small>
    </div>
</div>

<div class="form-group mb-0">
    <label for="degree_program">Programa académico</label>
    <input type="text" name="degree_program" id="degree_program"
        class="form-control @error('degree_program') is-invalid @enderror"
        value="{{ old('degree_program', $student->degree_program ?? '') }}"
        placeholder="Ej. Ingeniería de Sistemas">
    @error('degree_program')
        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
    @enderror
</div>
