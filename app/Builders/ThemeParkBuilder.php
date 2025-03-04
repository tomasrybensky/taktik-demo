<?php

namespace App\Builders;

use Illuminate\Database\Eloquent\Builder;

class ThemeParkBuilder extends Builder
{
    public function withAverageRating(): static
    {
        return $this->withAvg('ratings', 'rating');
    }
}
