<?php

use App\Models\ThemePark;
use App\Models\User;
use Laravel\Sanctum\Sanctum;

uses(\Illuminate\Foundation\Testing\DatabaseTransactions::class);

test('use can update own rating', function () {
    $user = User::factory()->create()->assignRole('user');

    Sanctum::actingAs($user);

    $themePark = ThemePark::factory()->create();
    $rating = $themePark->ratings()->create([
        'rating' => 5,
        'comment' => 'Great theme park!',
        'user_id' => $user->id,
    ]);

    $this->assertDatabaseHas('ratings', [
        'rating' => 5,
        'comment' => 'Great theme park!',
        'user_id' => $user->id,
        'ratable_id' => $themePark->id,
        'ratable_type' => ThemePark::class,
    ]);

    $response = $this->putJson("/api/ratings/{$rating->id}", [
        'rating' => 4,
        'comment' => 'Good theme park!',
    ]);

    $response->assertSuccessful()
        ->assertJson([
            'data' => [
                'rating' => 4,
                'comment' => 'Good theme park!',
            ],
        ]);

    $this->assertDatabaseHas('ratings', [
        'rating' => 4,
        'comment' => 'Good theme park!',
        'user_id' => $user->id,
        'ratable_id' => $themePark->id,
        'ratable_type' => ThemePark::class,
    ]);
});

test('user cannot update other user rating', function () {
    $user = User::factory()->create()->assignRole('user');
    $otherUser = User::factory()->create()->assignRole('user');

    Sanctum::actingAs($user);

    $themePark = ThemePark::factory()->create();
    $rating = $themePark->ratings()->create([
        'rating' => 5,
        'comment' => 'Great theme park!',
        'user_id' => $otherUser->id,
    ]);

    $this->assertDatabaseHas('ratings', [
        'rating' => 5,
        'comment' => 'Great theme park!',
        'user_id' => $otherUser->id,
        'ratable_id' => $themePark->id,
        'ratable_type' => ThemePark::class,
    ]);

    $response = $this->putJson("/api/ratings/{$rating->id}", [
        'rating' => 4,
        'comment' => 'Good theme park!',
    ]);

    $response->assertForbidden();

    $this->assertDatabaseHas('ratings', [
        'rating' => 5,
        'comment' => 'Great theme park!',
        'user_id' => $otherUser->id,
        'ratable_id' => $themePark->id,
        'ratable_type' => ThemePark::class,
    ]);
});
