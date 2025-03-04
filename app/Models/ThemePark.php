<?php

namespace App\Models;

use App\Builders\ThemeParkBuilder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class ThemePark extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
    ];

    public function newEloquentBuilder($query): ThemeParkBuilder
    {
        return new ThemeParkBuilder($query);
    }

    public function rollerCoasters(): HasMany
    {
        return $this->hasMany(RollerCoaster::class);
    }

    public function ratings(): MorphMany
    {
        return $this->morphMany(Rating::class, 'ratable');
    }
}
