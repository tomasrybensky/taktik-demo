<?php

use App\Models\User;
use Laravel\Sanctum\Sanctum;

uses(\Illuminate\Foundation\Testing\DatabaseTransactions::class);

test('manufacturer can be created by admin', function () {
    Sanctum::actingAs(
        User::factory()->create()->assignRole('admin'),
    );

    $this->assertDatabaseMissing('manufacturers', [
        'name' => 'B&M',
        'description' => 'Bolliger & Mabillard',
        'website' => 'https://www.bolliger-mabillard.com/',
    ]);

    $response = $this->postJson('/api/manufacturers', [
        'name' => 'B&M',
        'description' => 'Bolliger & Mabillard',
        'website' => 'https://www.bolliger-mabillard.com/',
    ]);

    $response->assertStatus(201)
        ->assertJson([
            'data' => [
                'name' => 'B&M',
                'description' => 'Bolliger & Mabillard',
                'website' => 'https://www.bolliger-mabillard.com/',
            ],
        ]);

    $this->assertDatabaseHas('manufacturers', [
        'name' => 'B&M',
        'description' => 'Bolliger & Mabillard',
        'website' => 'https://www.bolliger-mabillard.com/',
    ]);
});

test('manufacturer cannot be created by user', function () {
    Sanctum::actingAs(
        User::factory()->create()->assignRole('user'),
    );

    $response = $this->postJson('/api/manufacturers', [
        'name' => 'B&M',
        'description' => 'Bolliger & Mabillard',
        'website' => 'https://www.bolliger-mabillard.com/',
    ]);

    $response->assertStatus(403);

    $this->assertDatabaseMissing('manufacturers', [
        'name' => 'B&M',
        'description' => 'Bolliger & Mabillard',
        'website' => 'https://www.bolliger-mabillard.com/',
    ]);
});

test('manufacturer cannot be created by guest', function () {
    $response = $this->postJson('/api/manufacturers', [
        'name' => 'B&M',
        'description' => 'Bolliger & Mabillard',
        'website' => 'https://www.bolliger-mabillard.com/',
    ]);

    $response->assertStatus(401);

    $this->assertDatabaseMissing('manufacturers', [
        'name' => 'B&M',
        'description' => 'Bolliger & Mabillard',
        'website' => 'https://www.bolliger-mabillard.com/',
    ]);
});
