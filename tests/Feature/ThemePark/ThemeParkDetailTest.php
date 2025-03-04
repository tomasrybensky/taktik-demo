<?php

use App\Models\Rating;
use App\Models\ThemePark;

uses(\Illuminate\Foundation\Testing\DatabaseTransactions::class);

test('test theme park detail ratings', function () {
    $themePark = ThemePark::factory()->create();

    Rating::factory()->create([
        'ratable_id' => $themePark->id,
        'ratable_type' => ThemePark::class,
        'rating' => 5,
    ]);

    Rating::factory()->create([
        'ratable_id' => $themePark->id,
        'ratable_type' => ThemePark::class,
        'rating' => 1,
    ]);

    $response = $this->getJson('/api/theme-parks');

    $response->assertSuccessful();

    expect($response->getData('data')['data'][0]['average_rating'])->toEqual(3);
});
