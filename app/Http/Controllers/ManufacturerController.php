<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateOrUpdateManufacturerRequest;
use App\Http\Resources\ManufacturerResource;
use App\Models\Manufacturer;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ManufacturerController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        return ManufacturerResource::collection(
            Manufacturer::query()->orderBy('name')->get()
        );
    }

    public function store(CreateOrUpdateManufacturerRequest $request): ManufacturerResource
    {
        $manufacturer = Manufacturer::query()->create($request->validated());

        return ManufacturerResource::make($manufacturer);
    }

    public function show(Manufacturer $manufacturer): ManufacturerResource
    {
        return ManufacturerResource::make($manufacturer);
    }

    public function update(
        Manufacturer $manufacturer,
        CreateOrUpdateManufacturerRequest $request
    ): ManufacturerResource {
        $manufacturer->update($request->validated());

        return ManufacturerResource::make($manufacturer);
    }

    public function destroy(Manufacturer $manufacturer): JsonResponse
    {
        $manufacturer->delete();

        return response()->json();
    }
}
