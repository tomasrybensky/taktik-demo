<?php

namespace App\Models;

use App\Builders\RollerCoasterBuilder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class RollerCoaster extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'speed',
        'height',
        'length',
        'inversions',
        'manufacturer_id',
        'theme_park_id',
    ];

    public function newEloquentBuilder($query): RollerCoasterBuilder
    {
        return new RollerCoasterBuilder($query);
    }

    public function manufacturer(): BelongsTo
    {
        return $this->belongsTo(Manufacturer::class);
    }

    public function themePark(): BelongsTo
    {
        return $this->belongsTo(ThemePark::class);
    }

    public function ratings(): MorphMany
    {
        return $this->morphMany(Rating::class, 'ratable');
    }
}
