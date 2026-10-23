<?php

use App\Models\Club;
use App\Models\Enrollment;
use App\Models\Student;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('un invitado es redirigido al login desde estudiantes y clubes', function () {
    $this->get('/students')->assertRedirect('/login');
    $this->get('/clubs')->assertRedirect('/login');
});

test('el listado de estudiantes y clubes carga para un usuario autenticado', function () {
    $user = User::factory()->create();

    $this->actingAs($user)->get('/students')->assertOk()->assertSee('Estudiantes');
    $this->actingAs($user)->get('/clubs')->assertOk()->assertSee('Clubes');
});

test('se registra un estudiante con datos válidos', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->post('/students', [
            'first_name' => 'Ana',
            'last_name' => 'Pérez',
            'email' => 'ana.perez@example.test',
        ])
        ->assertRedirect('/students');

    $this->assertDatabaseHas('students', ['email' => 'ana.perez@example.test']);
});

test('se registra un club con estudiantes inscritos', function () {
    $user = User::factory()->create();
    $student = Student::factory()->create();

    $this->actingAs($user)
        ->post('/clubs', [
            'name' => 'Club de Robótica',
            'students' => [$student->id],
        ])
        ->assertRedirect();

    $club = Club::where('name', 'Club de Robótica')->first();

    expect($club)->not->toBeNull();

    $club->refresh();

    expect($club->status)->toBeTrue();
    expect($club->registered_by)->toBe($user->id);

    $this->assertDatabaseHas('enrollments', [
        'club_id' => $club->id,
        'student_id' => $student->id,
        'status' => 'active',
    ]);
});

test('se sincronizan las inscripciones al editar un club', function () {
    $user = User::factory()->create();
    $primero = Student::factory()->create();
    $segundo = Student::factory()->create();
    $club = Club::factory()->create(['name' => 'Club de Teatro']);

    $this->actingAs($user)
        ->put("/clubs/{$club->id}", [
            'name' => 'Club de Teatro',
            'students' => [$primero->id],
        ])
        ->assertRedirect("/clubs/{$club->id}");

    $this->assertDatabaseHas('enrollments', ['club_id' => $club->id, 'student_id' => $primero->id]);

    $this->actingAs($user)
        ->put("/clubs/{$club->id}", [
            'name' => 'Club de Teatro',
            'students' => [$segundo->id],
        ]);

    $this->assertDatabaseMissing('enrollments', ['club_id' => $club->id, 'student_id' => $primero->id]);
    $this->assertDatabaseHas('enrollments', ['club_id' => $club->id, 'student_id' => $segundo->id]);
});

test('al eliminar un club se eliminan sus inscripciones', function () {
    $user = User::factory()->create();
    $student = Student::factory()->create();
    $club = Club::factory()->create();
    Enrollment::create([
        'student_id' => $student->id,
        'club_id' => $club->id,
        'enrollment_date' => now(),
        'status' => 'active',
    ]);

    $this->actingAs($user)
        ->delete("/clubs/{$club->id}")
        ->assertRedirect('/clubs');

    $this->assertDatabaseMissing('clubs', ['id' => $club->id]);
    $this->assertDatabaseMissing('enrollments', ['club_id' => $club->id]);
});

test('al eliminar un estudiante se eliminan sus inscripciones', function () {
    $user = User::factory()->create();
    $student = Student::factory()->create();
    $club = Club::factory()->create();
    Enrollment::create([
        'student_id' => $student->id,
        'club_id' => $club->id,
        'enrollment_date' => now(),
        'status' => 'active',
    ]);

    $this->actingAs($user)
        ->delete("/students/{$student->id}")
        ->assertRedirect('/students');

    $this->assertDatabaseMissing('students', ['id' => $student->id]);
    $this->assertDatabaseMissing('enrollments', ['student_id' => $student->id]);
});
