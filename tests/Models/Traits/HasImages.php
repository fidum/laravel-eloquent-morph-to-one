<?php

namespace Fidum\EloquentMorphToOne\Tests\Models\Traits;

use Fidum\EloquentMorphToOne\HasMorphToOne;
use Fidum\EloquentMorphToOne\MorphToOne;
use Fidum\EloquentMorphToOne\Tests\Models\Image;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

trait HasImages
{
    use HasMorphToOne;

    /** @return MorphToOne<Image, $this> */
    public function featuredImage(): MorphToOne
    {
        return $this->morphToOne(Image::class, 'imageable')
            ->withPivot('is_featured')
            ->wherePivot('is_featured', 1);
    }

    /** @return MorphToOne<Image, $this> */
    public function featuredImageWithDefault(): MorphToOne
    {
        return $this->morphToOne(Image::class, 'imageable')
            ->withPivot('is_featured')
            ->wherePivot('is_featured', 1)
            ->withDefault();
    }

    /** @return MorphToMany<Image, $this> */
    public function images(): MorphToMany
    {
        return $this->morphToMany(Image::class, 'imageable')
            ->withPivot(['is_featured']);
    }
}
