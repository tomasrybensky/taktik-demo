<?php

use App\Models\ThemePark;
use App\Models\User;
use Laravel\Sanctum\Sanctum;

uses(\Illuminate\Foundation\Testing\DatabaseTransactions::class);

test('theme park can be deleted by admin', function () {
    Sanctum::actingAs(
        User::factory()->create()->assignRole('admin'),
    );

    $themePark = ThemePark::factory()->create();

    $response = $this->deleteJson("/api/theme-parks/{$themePark->id}");

    $response->assertSuccessful();

    $this->assertDatabaseMissing('theme_parks', [
        'id' => $themePark->id,
    ]);
});

test('theme park cannot be deleted by user', function () {
    Sanctum::actingAs(
        User::factory()->create()->assignRole('user'),
    );

    $themePark = ThemePark::factory()->create();

    $response = $this->deleteJson("/api/theme-parks/{$themePark->id}");

    $response->assertForbidden();

    $this->assertDatabaseHas('theme_parks', [
        'id' => $themePark->id,
    ]);
});

test('theme park cannot be deleted by guest', function () {
    $themePark = ThemePark::factory()->create();

    $response = $this->deleteJson("/api/theme-parks/{$themePark->id}");

    $response->assertUnauthorized();

    $this->assertDatabaseHas('theme_parks', [
        'id' => $themePark->id,
    ]);
});
