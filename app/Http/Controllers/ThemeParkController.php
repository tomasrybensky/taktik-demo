<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateOrUpdateThemeParkRequest;
use App\Http\Resources\ThemeParkResource;
use App\Models\ThemePark;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Cache;

class ThemeParkController extends Controller
{
    /**
     * @response AnonymousResourceCollection<ThemeParkResource>
     */
    public function index(): AnonymousResourceCollection
    {
        return Cache::remember(
            'theme-parks.' . request()->getQueryString(),
            config('cache.default_ttl'),
            function () {
                $themeParks = ThemePark::query()
                    ->withAverageRating()
                    ->withCount('rollerCoasters')
                    ->orderBy('name')
                    ->get();

                return ThemeParkResource::collection($themeParks);
            });
    }

    public function store(CreateOrUpdateThemeParkRequest $request): ThemeParkResource
    {
        $themePark = ThemePark::query()->create($request->validated());
        Cache::flush();

        return ThemeParkResource::make($themePark);
    }

    public function show(ThemePark $themePark): ThemeParkResource
    {
        return ThemeParkResource::make(
            $themePark->loadMissing('ratings', 'rollerCoasters')
        );
    }

    public function update(
        ThemePark $themePark,
        CreateOrUpdateThemeParkRequest $request
    ): ThemeParkResource {
        $themePark->update($request->validated());
        Cache::flush();

        return ThemeParkResource::make($themePark);
    }

    public function destroy(ThemePark $themePark): JsonResponse
    {
        $themePark->delete();
        Cache::flush();

        return response()->json();
    }
}
