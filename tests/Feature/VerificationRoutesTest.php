<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Route;

uses(RefreshDatabase::class);

test('las rutas de verificación están registradas', function () {
    expect(Route::has('verification.notice'))->toBeTrue();
    expect(Route::has('verification.resend'))->toBeTrue();
    expect(Route::has('verification.verify'))->toBeTrue();
});

test('la verificación no bloquea el registro de estudiantes ni de clubes', function () {
    $user = User::factory()->unverified()->create();

    $this->actingAs($user)
        ->get('/students')
        ->assertOk();

    $this->actingAs($user)
        ->get('/clubs')
        ->assertOk();
});
