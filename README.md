# Adds MorphToOne relation to Laravel eloquent

[![Latest Version on Packagist](https://img.shields.io/packagist/v/fidum/laravel-eloquent-morph-to-one.svg?style=for-the-badge)](https://packagist.org/packages/fidum/laravel-eloquent-morph-to-one)
[![GitHub Workflow Status (with branch)](https://img.shields.io/github/actions/workflow/status/fidum/laravel-eloquent-morph-to-one/run-tests.yml?branch=main&style=for-the-badge)](https://github.com/fidum/laravel-eloquent-morph-to-one/actions?query=workflow%3Arun-tests+branch%3Amaster)
[![Codecov](https://img.shields.io/codecov/c/github/fidum/laravel-eloquent-morph-to-one?logo=codecov&logoColor=white&style=for-the-badge)](https://codecov.io/gh/fidum/laravel-eloquent-morph-to-one)
[![Twitter Follow](https://img.shields.io/twitter/follow/danmasonmp?label=Follow&logo=twitter&style=for-the-badge)](https://twitter.com/danmasonmp) 

:mega: Shoutout to [Ankur Kumar](https://github.com/ankurk91) who wrote the original code for this relation in their package [Eloquent Relations](https://github.com/ankurk91/laravel-eloquent-relationships). I created this package as I needed to make a few tweaks to suit my needs. :raised_hands:

## Installation

You can install the package via composer:

```bash
composer require fidum/laravel-eloquent-morph-to-one
```

## Usage

The `MorphToOne` relation is uses Laravel's [MorphToMany](https://laravel.com/docs/7.x/eloquent-relationships#many-to-many-polymorphic-relations) under the hood. However, the difference is that it returns **one** model instead of a `Collection` of models. 

If there is no related model in the database it will return `null` where `MorphToMany` would return an empty `Collection`.

Example:
```php
<?php

namespace App;

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

```php
<?php

namespace App;

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

Now you can access the relationship like:
```php
<?php

// eager loading
$post = Post::with('featuredImage')->first();
dump($post->featuredImage);
// lazy loading
$post->load('featuredImage');
```
Prefer using `sync` instead of `save` when updating your relation. 
```php
$post->featuredImage()->sync([Image::find(123)]);
$post->featuredImage()->sync([Image::find(456)]);
$post->images->count(); // 1 row :)
```

:x: DO NOT use `save` it will follow `morphToMany` behaviour and create rather than update existing.
```php
$post->featuredImage()->save(Image::find(123));
$post->featuredImage()->save(Image::find(456));
$post->images->count(); // 2 rows :(
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
