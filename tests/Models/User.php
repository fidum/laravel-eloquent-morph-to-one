<?php

namespace Fidum\EloquentMorphToOne\Tests\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @property-read Image|null $featuredImage
 * @property-read Image $featuredImageWithDefault
 */
class User extends Model
{
    use Traits\HasImages;

    protected $guarded = ['id'];

    /** @return BelongsToMany<Restaurant, $this> */
    public function restaurants(): BelongsToMany
    {
        return $this->belongsToMany(Restaurant::class)
            ->withPivot('is_operator')
            ->withTimestamps();
    }
}
