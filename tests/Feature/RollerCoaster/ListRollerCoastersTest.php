<?php

use App\Models\RollerCoaster;

uses(\Illuminate\Foundation\Testing\DatabaseTransactions::class);

test('test roller coasters list', function () {
    RollerCoaster::factory()->count(3)->create();

    $response = $this->getJson('/api/roller-coasters');

    $response->assertSuccessful()
        ->assertJsonCount(3, 'data');
});
