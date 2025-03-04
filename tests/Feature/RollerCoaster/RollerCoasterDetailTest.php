<?php

use App\Models\Rating;
use App\Models\RollerCoaster;

uses(\Illuminate\Foundation\Testing\DatabaseTransactions::class);

test('test roller coasters detail ratings', function () {
    $rollerCoaster = RollerCoaster::factory()->create();

    Rating::factory()->create([
        'ratable_id' => $rollerCoaster->id,
        'ratable_type' => RollerCoaster::class,
        'rating' => 5,
    ]);

    Rating::factory()->create([
        'ratable_id' => $rollerCoaster->id,
        'ratable_type' => RollerCoaster::class,
        'rating' => 1,
    ]);

    $response = $this->getJson('/api/roller-coasters');

    $response->assertSuccessful();

    expect($response->getData('data')['data'][0]['average_rating'])->toEqual(3);
});
