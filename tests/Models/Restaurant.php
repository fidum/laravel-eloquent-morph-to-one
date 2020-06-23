<?php

namespace Fidum\EloquentMorphToOne\Tests\Models;

use Illuminate\Database\Eloquent\Model;

class Restaurant extends Model
{
    use Traits\HasImages;

    protected $guarded = ['id'];
}
