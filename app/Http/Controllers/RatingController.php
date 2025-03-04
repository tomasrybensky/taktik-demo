<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateOrUpdateRatingRequest;
use App\Http\Resources\RatingResource;
use App\Models\Rating;
use App\Models\RollerCoaster;
use App\Models\ThemePark;
use Illuminate\Http\JsonResponse;

class RatingController extends Controller
{
    public function update(
        Rating $rating,
        CreateOrUpdateRatingRequest $request
    ): RatingResource {
        if (! auth()->user()->can('update', $rating)) {
            abort(403);
        }

        $rating->update($request->validated());

        return RatingResource::make($rating);
    }

    public function destroy(Rating $rating): JsonResponse
    {
        if (! auth()->user()->can('delete', $rating)) {
            abort(403);
        }

        if (auth()->user()->can('delete', $rating)) {
            $rating->delete();
        }

        return response()->json();
    }

    public function storeRollerCoasterRating(
        RollerCoaster $rollerCoaster,
        CreateOrUpdateRatingRequest $request
    ): RatingResource {
        $rating = $rollerCoaster->ratings()->create(
            array_merge($request->validated(), ['user_id' => auth()->id()])
        );

        return RatingResource::make($rating);
    }

    public function storeThemeParkRating(
        ThemePark $themePark,
        CreateOrUpdateRatingRequest $request
    ): RatingResource {
        $rating = $themePark->ratings()->create(
            array_merge($request->validated(), ['user_id' => auth()->id()])
        );

        return RatingResource::make($rating);
    }
}
