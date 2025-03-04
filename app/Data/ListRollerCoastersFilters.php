<?php

namespace App\Data;

use Spatie\LaravelData\Data;

class ListRollerCoastersFilters extends Data
{
    public function __construct(
        public ?int $manufacturerId = null,
        public ?int $themeParkId = null,
        public ?int $minLength = null,
        public ?int $maxLength = null,
        public ?int $minHeight = null,
        public ?int $maxHeight = null,
        public ?int $minInversions = null,
        public ?int $maxInversions = null,
        public ?int $minSpeed = null,
        public ?int $maxSpeed = null,
        public int $perPage = 10,
        public int $page = 1,
        public ?string $groupBy = null,
        public ?string $sortBy = null,
        public ?string $sortDirection = null,
    ) {}
}
