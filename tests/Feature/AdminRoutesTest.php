<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('un invitado es redirigido a login desde dashboard y settings', function () {
    $this->get('/dashboard')->assertRedirect('/login');
    $this->get('/settings')->assertRedirect('/login');
});

test('un usuario autenticado accede a dashboard y settings', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->get('/dashboard')
        ->assertOk()
        ->assertSee('Panel');

    $this->actingAs($user)
        ->get('/settings')
        ->assertOk()
        ->assertSee('Configuración');
});
