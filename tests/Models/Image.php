<?php

namespace Fidum\EloquentMorphToOne\Tests\Models;

use Fidum\EloquentMorphToOne\HasMorphToOne;
use Fidum\EloquentMorphToOne\MorphToOne;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphPivot;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

/**
 * @property-read (MorphPivot&object{is_featured: int})|null $pivot
 * @property-read Restaurant|null $restaurant
 * @property-read User|null $user
 */
class Image extends Model
{
    use HasMorphToOne;

    protected $guarded = ['id'];

    /** @return MorphToMany<User, $this> */
    public function users(): MorphToMany
    {
        return $this->morphedByMany(User::class, 'imageable');
    }

    /** @return MorphToMany<Restaurant, $this> */
    public function restaurants(): MorphToMany
    {
        return $this->morphedByMany(Restaurant::class, 'imageable');
    }

    /** @return MorphToOne<Restaurant, $this> */
    public function restaurant(): MorphToOne
    {
        return $this->morphedByOne(Restaurant::class, 'imageable')
            ->wherePivot('is_featured', 1);
    }

    /** @return MorphToOne<User, $this> */
    public function user(): MorphToOne
    {
        return $this->morphedByOne(User::class, 'imageable')
            ->wherePivot('is_featured', 1);
    }
}
