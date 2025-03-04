<?php

namespace App\Builders;

use App\Data\ListRollerCoastersFilters;
use Illuminate\Database\Eloquent\Builder;

class RollerCoasterBuilder extends Builder
{
    public function applyRollerCoasterFilters(ListRollerCoastersFilters $filters): static
    {
        if ($filters->manufacturerId) {
            $this->where('manufacturer_id', $filters->manufacturerId);
        }
        if ($filters->themeParkId) {
            $this->where('theme_park_id', $filters->themeParkId);
        }
        if ($filters->minSpeed) {
            $this->where('speed', '>=', $filters->minSpeed);
        }
        if ($filters->maxSpeed) {
            $this->where('speed', '<=', $filters->maxSpeed);
        }
        if ($filters->minHeight) {
            $this->where('height', '>=', $filters->minHeight);
        }
        if ($filters->maxHeight) {
            $this->where('height', '<=', $filters->maxHeight);
        }
        if ($filters->minLength) {
            $this->where('length', '>=', $filters->minLength);
        }
        if ($filters->maxLength) {
            $this->where('length', '<=', $filters->maxLength);
        }
        if ($filters->minInversions) {
            $this->where('inversions', '>=', $filters->minInversions);
        }
        if ($filters->maxInversions) {
            $this->where('inversions', '<=', $filters->maxInversions);
        }

        $this->sortBy($filters->sortBy ?? 'rating', $filters->sortDirection ?? 'desc');

        if ($filters->groupBy) {
            $this->groupBy($filters->groupBy);
        }

        return $this;
    }

    public function sortBy(string $sortBy, string $sortOrder): static
    {
        if ($sortBy === 'rating') {
            return $this->withAverageRating()->orderBy('ratings_avg_rating', $sortOrder);
        }

        return $this->orderBy($sortBy, $sortOrder);
    }

    public function withAverageRating(): static
    {
        return $this->withAvg('ratings', 'rating');
    }
}
