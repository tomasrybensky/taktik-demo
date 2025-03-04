<?php

use App\Models\Manufacturer;
use App\Models\User;
use Laravel\Sanctum\Sanctum;

uses(\Illuminate\Foundation\Testing\DatabaseTransactions::class);

test('manufacturer can be updated by admin', function () {
    $manufacturer = Manufacturer::factory()->create();

    Sanctum::actingAs(
        User::factory()->create()->assignRole('admin'),
    );

    $this->assertDatabaseMissing('manufacturers', [
        'name' => 'Intamin',
        'description' => 'Intamin Amusement Rides',
        'website' => 'https://www.intamin.com/',
    ]);

    $response = $this->putJson("/api/manufacturers/{$manufacturer->id}", [
        'name' => 'Intamin',
        'description' => 'Intamin Amusement Rides',
        'website' => 'https://www.intamin.com/',
    ]);

    $response->assertStatus(200)
        ->assertJson([
            'data' => [
                'name' => 'Intamin',
                'description' => 'Intamin Amusement Rides',
                'website' => 'https://www.intamin.com/',
            ],
        ]);

    $this->assertDatabaseHas('manufacturers', [
        'name' => 'Intamin',
        'description' => 'Intamin Amusement Rides',
        'website' => 'https://www.intamin.com/',
    ]);
});

test('manufacturer cannot be updated by user', function () {
    $manufacturer = Manufacturer::factory()->create();

    Sanctum::actingAs(
        User::factory()->create()->assignRole('user'),
    );

    $response = $this->putJson("/api/manufacturers/{$manufacturer->id}", [
        'name' => 'Intamin',
        'description' => 'Intamin Amusement Rides',
        'website' => 'https://www.intamin.com/',
    ]);

    $response->assertStatus(403);

    $this->assertDatabaseMissing('manufacturers', [
        'name' => 'Intamin',
        'description' => 'Intamin Amusement Rides',
        'website' => 'https://www.intamin.com/',
    ]);
});

test('manufacturer cannot be updated by guest', function () {
    $manufacturer = Manufacturer::factory()->create();

    $response = $this->putJson("/api/manufacturers/{$manufacturer->id}", [
        'name' => 'Intamin',
        'description' => 'Intamin Amusement Rides',
        'website' => 'https://www.intamin.com/',
    ]);

    $response->assertStatus(401);

    $this->assertDatabaseMissing('manufacturers', [
        'name' => 'Intamin',
        'description' => 'Intamin Amusement Rides',
        'website' => 'https://www.intamin.com/',
    ]);
});
