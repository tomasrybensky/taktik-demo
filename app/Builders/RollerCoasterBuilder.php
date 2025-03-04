<?php

namespace App\Builders;

use App\Data\ListRollerCoastersFilters;
use Illuminate\Database\Eloquent\Builder;

class RollerCoasterBuilder extends Builder
{
    public function applyRollerCoasterFilters(ListRollerCoastersFilters $filters): static
    {
        $filterMappings = [
            'manufacturerId' => 'manufacturer_id',
            'themeParkId' => 'theme_park_id',
            'minSpeed' => ['speed', '>='],
            'maxSpeed' => ['speed', '<='],
            'minHeight' => ['height', '>='],
            'maxHeight' => ['height', '<='],
            'minLength' => ['length', '>='],
            'maxLength' => ['length', '<='],
            'minInversions' => ['inversions', '>='],
            'maxInversions' => ['inversions', '<='],
        ];

        foreach ($filterMappings as $filterKey => $dbColumn) {
            if ($filters->$filterKey) {
                if (is_array($dbColumn)) {
                    [$dbColumnName, $operator] = $dbColumn;
                    $this->where($dbColumnName, $operator, $filters->$filterKey);
                } else {
                    $this->where($dbColumn, $filters->$filterKey);
                }
            }
        }

        $this->sortBy($filters->sortBy ?? 'rating', $filters->sortDirection ?? 'desc');

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
