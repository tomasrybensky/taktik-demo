<?php

use App\Models\ThemePark;
use App\Models\User;
use Laravel\Sanctum\Sanctum;

uses(\Illuminate\Foundation\Testing\DatabaseTransactions::class);

test('theme park can be updated by admin', function () {
    Sanctum::actingAs(
        User::factory()->create()->assignRole('admin'),
    );

    $themePark = ThemePark::factory()->create();

    $this->assertDatabaseMissing('theme_parks', [
        'name' => 'Europa-Park',
    ]);

    $response = $this->putJson("/api/theme-parks/{$themePark->id}", [
        'name' => 'Europa-Park',
        'description' => 'Europa-Park',
    ]);

    $response->assertSuccessful()
        ->assertJson([
            'data' => [
                'name' => 'Europa-Park',
                'description' => 'Europa-Park',
            ],
        ]);

    $this->assertDatabaseHas('theme_parks', [
        'name' => 'Europa-Park',
    ]);
});

test('theme park cannot be updated by user', function () {
    Sanctum::actingAs(
        User::factory()->create()->assignRole('user'),
    );

    $themePark = ThemePark::factory()->create();

    $response = $this->putJson("/api/theme-parks/{$themePark->id}", [
        'name' => 'Europa-Park',
        'description' => 'Europa-Park',
        'website' => 'https://www.europapark.de/',
    ]);

    $response->assertForbidden();

    $this->assertDatabaseMissing('theme_parks', [
        'name' => 'Europa-Park',
    ]);
});

test('theme park cannot be updated by guest', function () {
    $themePark = ThemePark::factory()->create();

    $response = $this->putJson("/api/theme-parks/{$themePark->id}", [
        'name' => 'Europa-Park',
        'description' => 'Europa-Park',
        'website' => 'https://www.europapark.de/',
    ]);

    $response->assertUnauthorized();

    $this->assertDatabaseMissing('theme_parks', [
        'name' => 'Europa-Park',
    ]);
});
