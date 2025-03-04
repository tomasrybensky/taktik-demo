<?php

namespace App\Http\Controllers;

use App\Data\ListRollerCoastersFilters;
use App\Http\Requests\CreateOrUpdateRollerCoasterRequest;
use App\Http\Requests\GetRollerCoastersRequest;
use App\Http\Resources\RollerCoasterResource;
use App\Models\RollerCoaster;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Cache;

class RollerCoasterController extends Controller
{
    /**
     * @response AnonymousResourceCollection<RollerCoasterResource>
     */
    public function index(GetRollerCoastersRequest $request): AnonymousResourceCollection
    {
        return Cache::remember(
            'roller-coasters.' . request()->getQueryString(),
            config('cache.default_ttl'),
            function () {
                $filters = ListRollerCoastersFilters::from(request()->query());

                $rollerCoasters = RollerCoaster::query()
                    ->applyRollerCoasterFilters($filters)
                    ->with(['manufacturer', 'themePark'])
                    ->paginate(request()->query('per_page', 10));

                return RollerCoasterResource::collection($rollerCoasters);
            });
    }

    public function store(CreateOrUpdateRollerCoasterRequest $request): RollerCoasterResource
    {
        $rollerCoaster = RollerCoaster::query()->create($request->validated());
        Cache::flush();

        return RollerCoasterResource::make($rollerCoaster);
    }

    public function show(RollerCoaster $rollerCoaster): RollerCoasterResource
    {
        return RollerCoasterResource::make(
            $rollerCoaster->loadMissing(['manufacturer', 'themePark', 'ratings'])
        );
    }

    public function update(
        RollerCoaster $rollerCoaster,
        CreateOrUpdateRollerCoasterRequest $request
    ): RollerCoasterResource {
        $rollerCoaster->update($request->validated());
        Cache::flush();

        return RollerCoasterResource::make($rollerCoaster);
    }

    public function destroy(RollerCoaster $rollerCoaster): JsonResponse
    {
        $rollerCoaster->delete();
        Cache::flush();

        return response()->json();
    }
}
