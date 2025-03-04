<?php

namespace App\Builders;

use Illuminate\Database\Eloquent\Builder;

class ThemeParkBuilder extends Builder
{
    public function withAverageRatings(): static
    {
        return $this->withAvg('ratings', 'rating');
    }
}
