<?php

use App\Models\Manufacturer;
use App\Models\ThemePark;
use App\Models\User;
use Laravel\Sanctum\Sanctum;

uses(\Illuminate\Foundation\Testing\DatabaseTransactions::class);

test('admin can create new roller coaster', function () {
    Sanctum::actingAs(
        User::factory()->create()->assignRole('admin'),
    );

    $this->assertDatabaseMissing('roller_coasters', [
        'name' => 'Silver Star',
    ]);

    $manufacturer = Manufacturer::factory()->create();
    $themePark = ThemePark::factory()->create();

    $response = $this->postJson('/api/roller-coasters', [
        'name' => 'Silver Star',
        'description' => 'Silver Star',
        'manufacturer_id' => $manufacturer->id,
        'theme_park_id' => $themePark->id,
        'height' => 73,
        'speed' => 130,
        'length' => 1620,
        'inversions' => 0,
    ]);

    $response->assertCreated();

    $this->assertDatabaseHas('roller_coasters', [
        'name' => 'Silver Star',
    ]);
});

test('user cannot create new roller coaster', function () {
    Sanctum::actingAs(
        User::factory()->create()->assignRole('user'),
    );

    $manufacturer = Manufacturer::factory()->create();
    $themePark = ThemePark::factory()->create();

    $response = $this->postJson('/api/roller-coasters', [
        'name' => 'Silver Star',
        'description' => 'Silver Star',
        'manufacturer_id' => $manufacturer->id,
        'theme_park_id' => $themePark->id,
        'height' => 73,
        'speed' => 130,
        'length' => 1620,
        'inversions' => 0,
    ]);

    $response->assertForbidden();

    $this->assertDatabaseMissing('roller_coasters', [
        'name' => 'Silver Star',
    ]);
});

test('guest cannot create new roller coaster', function () {
    $manufacturer = Manufacturer::factory()->create();
    $themePark = ThemePark::factory()->create();

    $response = $this->postJson('/api/roller-coasters', [
        'name' => 'Silver Star',
        'description' => 'Silver Star',
        'manufacturer_id' => $manufacturer->id,
        'theme_park_id' => $themePark->id,
        'height' => 73,
        'speed' => 130,
        'length' => 1620,
        'inversions' => 0,
    ]);

    $response->assertUnauthorized();
});
