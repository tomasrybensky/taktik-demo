<?php

use App\Models\ThemePark;

uses(\Illuminate\Foundation\Testing\DatabaseTransactions::class);

test('theme parks list', function () {
    ThemePark::factory()->count(3)->create();

    $response = $this->getJson('/api/theme-parks');

    $response->assertSuccessful()
        ->assertJsonCount(3, 'data');
});
