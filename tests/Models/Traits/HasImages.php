<?php

namespace Fidum\EloquentMorphToOne\Tests\Models\Traits;

use Fidum\EloquentMorphToOne\MorphToOne;
use Fidum\EloquentMorphToOne\Tests\Models\Image;
use Fidum\EloquentMorphToOne\HasMorphToOne;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

trait HasImages
{
    use HasMorphToOne;

    public function featuredImage(): MorphToOne
    {
        return $this->morphToOne(Image::class, 'imageable')
            ->withPivot('is_featured')
            ->wherePivot('is_featured', 1);
    }

    public function featuredImageWithDefault(): MorphToOne
    {
        return $this->morphToOne(Image::class, 'imageable')
            ->withPivot('is_featured')
            ->wherePivot('is_featured', 1)
            ->withDefault();
    }

    public function images(): MorphToMany
    {
        return $this->morphToMany(Image::class, 'imageable')
            ->withPivot(['is_featured']);
    }
}
