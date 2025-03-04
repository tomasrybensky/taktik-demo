<?php

use App\Models\RollerCoaster;
use App\Models\ThemePark;
use App\Models\User;
use Laravel\Sanctum\Sanctum;

uses(\Illuminate\Foundation\Testing\DatabaseTransactions::class);

test('create theme park rating', function () {
    $user = User::factory()->create()->assignRole('user');

    Sanctum::actingAs($user);

    $themePark = ThemePark::factory()->create();

    $this->assertDatabaseMissing('ratings', [
        'rating' => 5,
        'comment' => 'Great theme park!',
        'user_id' => $user->id,
        'ratable_id' => $themePark->id,
        'ratable_type' => ThemePark::class,
    ]);

    $response = $this->postJson("/api/theme-parks/{$themePark->id}/ratings", [
        'rating' => 5,
        'comment' => 'Great theme park!',
    ]);

    $response->assertCreated()
        ->assertJson([
            'data' => [
                'rating' => 5,
                'comment' => 'Great theme park!',
            ],
        ]);

    $this->assertDatabaseHas('ratings', [
        'rating' => 5,
        'comment' => 'Great theme park!',
        'user_id' => $user->id,
        'ratable_id' => $themePark->id,
        'ratable_type' => ThemePark::class,
    ]);
});

test('create roller coaster rating', function () {
    $user = User::factory()->create()->assignRole('user');

    Sanctum::actingAs($user);

    $rollerCoaster = RollerCoaster::factory()->create();

    $this->assertDatabaseMissing('ratings', [
        'rating' => 5,
        'comment' => 'Great roller coaster!',
        'user_id' => $user->id,
        'ratable_id' => $rollerCoaster->id,
        'ratable_type' => RollerCoaster::class,
    ]);

    $response = $this->postJson("/api/roller-coasters/{$rollerCoaster->id}/ratings", [
        'rating' => 5,
        'comment' => 'Great roller coaster!',
    ]);

    $response->assertCreated()
        ->assertJson([
            'data' => [
                'rating' => 5,
                'comment' => 'Great roller coaster!',
            ],
        ]);

    $this->assertDatabaseHas('ratings', [
        'rating' => 5,
        'comment' => 'Great roller coaster!',
        'user_id' => $user->id,
        'ratable_id' => $rollerCoaster->id,
        'ratable_type' => RollerCoaster::class,
    ]);
});

test('unauthenticated user cannot create rating', function () {
    $themePark = ThemePark::factory()->create();

    $response = $this->postJson("/api/theme-parks/{$themePark->id}/ratings", [
        'rating' => 5,
        'comment' => 'Great theme park!',
    ]);

    $response->assertUnauthorized();
});

test('admin cannot create rating', function () {
    $user = User::factory()->create()->assignRole('admin');

    Sanctum::actingAs($user);

    $themePark = ThemePark::factory()->create();

    $response = $this->postJson("/api/theme-parks/{$themePark->id}/ratings", [
        'rating' => 5,
        'comment' => 'Great theme park!',
    ]);

    $response->assertForbidden();
});
