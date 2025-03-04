<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Rating extends Model
{
    use HasFactory;

    protected $fillable = [
        'rating',
        'comment',
        'user_id',
        'ratable_id',
        'ratable_type',
    ];

    public function ratable(): MorphTo
    {
        return $this->morphTo();
    }
}
