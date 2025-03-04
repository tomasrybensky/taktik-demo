<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RollerCoasterResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'manufacturer' => new ManufacturerResource($this->whenLoaded('manufacturer')),
            'theme_park' => new ThemeParkResource($this->whenLoaded('themePark')),
            'height' => $this->height,
            'length' => $this->length,
            'speed' => $this->speed,
            'inversions' => $this->inversions,
            'average_rating' => $this->ratings_avg_rating ?? null,

            // Ratings should be paginated in separate endpoint in real app
            'ratings' => RatingResource::collection($this->whenLoaded('ratings')),
        ];
    }
}
