<?php

use App\Models\Manufacturer;

uses(\Illuminate\Foundation\Testing\DatabaseTransactions::class);

test('manufacturers list', function () {
    Manufacturer::factory()->count(3)->create();

    $response = $this->getJson('/api/manufacturers');

    $response->assertStatus(200)
        ->assertJsonCount(3, 'data');
});
