<?php

use App\Models\Club;
use App\Models\Enrollment;
use App\Models\Student;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('un invitado es redirigido al login desde inscripciones', function () {
    $this->get('/inscripciones')->assertRedirect('/login');
    $this->get('/inscripciones/create')->assertRedirect('/login');
});

test('el listado de inscripciones carga y muestra el texto sin estudiantes', function () {
    $user = User::factory()->create();
    Club::factory()->create(['name' => 'Club sin miembros', 'status' => true]);

    $this->actingAs($user)
        ->get('/inscripciones')
        ->assertOk()
        ->assertSee('Enrollments')
        ->assertSee('No students yet');
});

test('el listado solo muestra clubes activos', function () {
    $user = User::factory()->create();
    Club::factory()->create(['name' => 'Club Activo', 'status' => true]);
    Club::factory()->create(['name' => 'Club Inactivo', 'status' => false]);

    $this->actingAs($user)
        ->get('/inscripciones')
        ->assertOk()
        ->assertSee('Club Activo')
        ->assertDontSee('Club Inactivo');
});

test('el formulario de inscripción carga estudiantes y clubes', function () {
    $user = User::factory()->create();
    $student = Student::factory()->create(['first_name' => 'Ana', 'last_name' => 'Pérez']);
    Club::factory()->create(['name' => 'Club de Robótica', 'status' => true]);

    $this->actingAs($user)
        ->get('/inscripciones/create')
        ->assertOk()
        ->assertSee('id="estudiantes"', false)
        ->assertSee('id="clubes"', false)
        ->assertSee('Ana')
        ->assertSee('Club de Robótica');
});

test('se inscribe cada estudiante en cada club seleccionado', function () {
    $user = User::factory()->create();
    $estudiantes = Student::factory()->count(2)->create();
    $clubes = Club::factory()->count(2)->create(['status' => true]);

    $this->actingAs($user)
        ->post('/inscripciones', [
            'estudiantes' => $estudiantes->pluck('id')->all(),
            'clubes' => $clubes->pluck('id')->all(),
        ])
        ->assertRedirect('/inscripciones')
        ->assertSessionHas('successMsg');

    expect(Enrollment::count())->toBe(4);

    foreach ($clubes as $club) {
        foreach ($estudiantes as $estudiante) {
            $this->assertDatabaseHas('enrollments', [
                'student_id' => $estudiante->id,
                'club_id' => $club->id,
                'status' => 'active',
                'registered_by' => $user->id,
            ]);
        }
    }
});

test('los pares ya inscritos se omiten y se informa cuántos existían', function () {
    $user = User::factory()->create();
    $estudiante = Student::factory()->create();
    $club = Club::factory()->create(['status' => true]);

    $datos = [
        'estudiantes' => [$estudiante->id],
        'clubes' => [$club->id],
    ];

    $this->actingAs($user)->post('/inscripciones', $datos)->assertSessionHas('successMsg');

    $this->actingAs($user)
        ->post('/inscripciones', $datos)
        ->assertRedirect('/inscripciones')
        ->assertSessionHas('successMsg', '0 new enrollments were created. 1 already existed and was skipped.');

    expect(Enrollment::count())->toBe(1);
});

test('no se acepta un club inactivo en la inscripción', function () {
    $user = User::factory()->create();
    $estudiante = Student::factory()->create();
    $club = Club::factory()->create(['status' => false]);

    $this->actingAs($user)
        ->post('/inscripciones', [
            'estudiantes' => [$estudiante->id],
            'clubes' => [$club->id],
        ])
        ->assertSessionHasErrors('clubes.0');

    expect(Enrollment::count())->toBe(0);
});
