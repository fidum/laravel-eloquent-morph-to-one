# Adds MorphToOne relation to Laravel eloquent

[![Latest Version on Packagist](https://img.shields.io/packagist/v/fidum/laravel-eloquent-morph-to-one.svg?style=flat-square)](https://packagist.org/packages/fidum/laravel-eloquent-morph-to-one)
[![GitHub Tests Action Status](https://img.shields.io/github/workflow/status/fidum/laravel-eloquent-morph-to-one/run-tests?label=tests)](https://github.com/fidum/laravel-eloquent-morph-to-one/actions?query=workflow%3Arun-tests+branch%3Amaster)
[![Total Downloads](https://img.shields.io/packagist/dt/fidum/laravel-eloquent-morph-to-one.svg?style=flat-square)](https://packagist.org/packages/fidum/laravel-eloquent-morph-to-one)


This is where your description should go. Limit it to a paragraph or two. Consider adding a small example.

## Installation

You can install the package via composer:

```bash
composer require fidum/laravel-eloquent-morph-to-one
```

## Usage

`MorphToOne` relation is almost identical to standard [MorphToMany](https://laravel.com/docs/7.x/eloquent-relationships#many-to-many-polymorphic-relations) except it returns one model instead of `Collection` of models 
and `null` if there is no related model in the database (`MorphToMany` returns empty `Collection` in this case). 
Example:
```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class Image extends Model
{
    public function posts(): MorphToMany
    {
        return $this->morphedByMany(Post::class, 'imageable');
    }

    public function videos(): MorphToMany
    {
        return $this->morphedByMany(Video::class, 'imageable');
    }
}
```
```php
<?php

namespace App\Models;

use Fidum\EloquentMorphToOne\HasMorphToOne;
use Fidum\EloquentMorphToOne\MorphToOne;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class Post extends Model
{
    use HasMorphToOne;

    public function featuredImage(): MorphToOne
    {
        return $this->morphToOne(Image::class, 'imageable')
            ->wherePivot('featured', 1);
            //->withDefault();
    }
    
    public function images(): MorphToMany
    {
        return $this->morphToMany(Image::class, 'imageable')
            ->withPivot('featured');
    }

}

```
Now you can access the relationship like:
```php
<?php

// eager loading
$post = Post::with('featuredImage')->first();
dump($post->featuredImage);
// lazy loading
$post->load('featuredImage');
```

## Testing

``` bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security

If you discover any security related issues, please email fidum.dev@gmail.com instead of using the issue tracker.

## Credits

- [Daniel Mason](https://github.com/fidum)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
