<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ThemeParkResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'average_rating' => $this->ratings_avg_rating ?? null,
            'roller_coasters_count' => $this->roller_coasters_count ?? null,
            'roller_coasters' => RollerCoasterResource::collection($this->whenLoaded('rollerCoasters')),

            // Ratings should be paginated in separate endpoint in real app
            'ratings' => RatingResource::collection($this->whenLoaded('ratings')),
        ];
    }
}
