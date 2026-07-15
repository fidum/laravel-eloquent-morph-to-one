<?php

namespace Fidum\EloquentMorphToOne\Tests\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property-read Image|null $featuredImage
 * @property-read Image $featuredImageWithDefault
 */
class Restaurant extends Model
{
    use Traits\HasImages;

    protected $guarded = ['id'];
}
