<?php

namespace Fidum\EloquentMorphToOne\Tests\Models;

use Fidum\EloquentMorphToOne\HasMorphToOne;
use Fidum\EloquentMorphToOne\MorphToOne;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class Image extends Model
{
    use HasMorphToOne;

    protected $guarded = ['id'];

    public function users(): MorphToMany
    {
        return $this->morphedByMany(User::class, 'imageable');
    }

    public function restaurants(): MorphToMany
    {
        return $this->morphedByMany(Restaurant::class, 'imageable');
    }

    public function restaurant(): MorphToOne
    {
        return $this->morphedByOne(Restaurant::class, 'imageable')
            ->wherePivot('is_featured', 1);
    }

    public function user(): MorphToOne
    {
        return $this->morphedByOne(User::class, 'imageable')
            ->wherePivot('is_featured', 1);
    }
}
