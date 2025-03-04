<?php

use App\Models\User;
use Laravel\Sanctum\Sanctum;

uses(\Illuminate\Foundation\Testing\DatabaseTransactions::class);

test('theme park can be created by admin', function () {
    Sanctum::actingAs(
        User::factory()->create()->assignRole('admin'),
    );

    $this->assertDatabaseMissing('theme_parks', [
        'name' => 'Europa-Park',
    ]);

    $response = $this->postJson('/api/theme-parks', [
        'name' => 'Europa-Park',
        'description' => 'Europa-Park',
    ]);

    $response->assertCreated()
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

test('theme park cannot be created by user', function () {
    Sanctum::actingAs(
        User::factory()->create()->assignRole('user'),
    );

    $response = $this->postJson('/api/theme-parks', [
        'name' => 'Europa-Park',
        'description' => 'Europa-Park',
        'website' => 'https://www.europapark.de/',
    ]);

    $response->assertForbidden();

    $this->assertDatabaseMissing('theme_parks', [
        'name' => 'Europa-Park',
    ]);
});

test('theme park cannot be created by guest', function () {
    $response = $this->postJson('/api/theme-parks', [
        'name' => 'Europa-Park',
        'description' => 'Europa-Park',
        'website' => 'https://www.europapark.de/',
    ]);

    $response->assertUnauthorized();

    $this->assertDatabaseMissing('theme_parks', [
        'name' => 'Europa-Park',
    ]);
});
