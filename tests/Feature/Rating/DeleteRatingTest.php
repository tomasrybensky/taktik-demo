<?php

use App\Models\ThemePark;
use App\Models\User;
use Laravel\Sanctum\Sanctum;

uses(\Illuminate\Foundation\Testing\DatabaseTransactions::class);

test('use can delete own rating', function () {
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

    $response = $this->deleteJson("/api/ratings/{$rating->id}");

    $response->assertSuccessful();

    $this->assertDatabaseMissing('ratings', [
        'rating' => 5,
        'comment' => 'Great theme park!',
        'user_id' => $user->id,
        'ratable_id' => $themePark->id,
        'ratable_type' => ThemePark::class,
    ]);
});

test('user cannot delete other user rating', function () {
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

    $response = $this->deleteJson("/api/ratings/{$rating->id}");

    $response->assertForbidden();

    $this->assertDatabaseHas('ratings', [
        'rating' => 5,
        'comment' => 'Great theme park!',
        'user_id' => $otherUser->id,
        'ratable_id' => $themePark->id,
        'ratable_type' => ThemePark::class,
    ]);
});
