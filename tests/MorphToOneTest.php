<?php

namespace Fidum\EloquentMorphToOne\Tests;

use Fidum\EloquentMorphToOne\Tests\Models\Image;
use Fidum\EloquentMorphToOne\Tests\Models\Restaurant;
use Fidum\EloquentMorphToOne\Tests\Models\User;

class MorphToOneTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $restaurant = Restaurant::create(['name' => 'ABC Inc']);
        $user = User::create(['email' => 'user@example.com']);
        $image = Image::create(['name' => 'Image']);

        $restaurant->images()->attach($image, [
            'is_featured' => 1,
        ]);
        $user->images()->attach($image, [
            'is_featured' => 1,
        ]);

        $imageTwo = Image::create(['name' => 'Another']);
        $restaurant->images()->attach($imageTwo);

        Restaurant::create(['name' => 'XYZ Inc']);
    }

    public function test_eager_loading(): void
    {
        $restaurant = Restaurant::with('featuredImage')->first();

        $this->assertInstanceOf(Image::class, $restaurant->featuredImage);
        $this->assertEquals(1, $restaurant->featuredImage->pivot->is_featured);
    }

    public function test_lazy_loading(): void
    {
        $restaurant = Restaurant::find(1);

        $this->assertInstanceOf(Image::class, $restaurant->featuredImage);
        $this->assertEquals(1, $restaurant->featuredImage->pivot->is_featured);
    }

    public function test_with_default(): void
    {
        $restaurant = Restaurant::find(2);

        $this->assertInstanceOf(Image::class, $restaurant->featuredImageWithDefault);
        $this->assertFalse($restaurant->featuredImageWithDefault->exists);
        $this->assertNull($restaurant->featuredImage);
    }

    public function test_reverse_relation(): void
    {
        $image = Image::first();

        $this->assertInstanceOf(Restaurant::class, $image->restaurant);
        $this->assertInstanceOf(User::class, $image->user);

        // image two is not a featured image
        $image = Image::find(2);
        $this->assertNull($image->restaurant);
    }
}
