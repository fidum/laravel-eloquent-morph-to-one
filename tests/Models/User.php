<?php

namespace Fidum\EloquentMorphToOne\Tests\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class User extends Model
{
    use Traits\HasImages;

    protected $guarded = ['id'];

    public function restaurants(): BelongsToMany
    {
        return $this->belongsToMany(Restaurant::class)
            ->withPivot('is_operator')
            ->withTimestamps();
    }
}
