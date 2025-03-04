<?php

use App\Models\Manufacturer;
use App\Models\User;
use Laravel\Sanctum\Sanctum;

uses(\Illuminate\Foundation\Testing\DatabaseTransactions::class);

test('manufacturer can be deleted by admin', function () {
    $manufacturer = Manufacturer::factory()->create();

    Sanctum::actingAs(
        User::factory()->create()->assignRole('admin'),
    );

    $response = $this->deleteJson("/api/manufacturers/{$manufacturer->id}");

    $response->assertSuccessful();

    $this->assertDatabaseMissing('manufacturers', [
        'id' => $manufacturer->id,
    ]);
});

test('manufacturer cannot be deleted by user', function () {
    $manufacturer = Manufacturer::factory()->create();

    Sanctum::actingAs(
        User::factory()->create()->assignRole('user'),
    );

    $response = $this->deleteJson("/api/manufacturers/{$manufacturer->id}");

    $response->assertStatus(403);

    $this->assertDatabaseHas('manufacturers', [
        'id' => $manufacturer->id,
    ]);
});

test('manufacturer cannot be deleted by guest', function () {
    $manufacturer = Manufacturer::factory()->create();

    $response = $this->deleteJson("/api/manufacturers/{$manufacturer->id}");

    $response->assertStatus(401);

    $this->assertDatabaseHas('manufacturers', [
        'id' => $manufacturer->id,
    ]);
});
