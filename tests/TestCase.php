<?php

namespace Fidum\EloquentMorphToOne\Tests;

use Illuminate\Database\Capsule\Manager as DB;
use Illuminate\Database\Schema\Blueprint;
use PHPUnit\Framework\TestCase as BaseTestCase;

class TestCase extends BaseTestCase
{
    public function setUp(): void
    {
        parent::setUp();

        $this->initDB();
        $this->migrateDB();
    }

    protected function initDB()
    {
        $db = new DB();
        $db->addConnection([
            'driver' => 'sqlite',
            'database' => ':memory:',
            'prefix' => '',
        ]);

        $db->setAsGlobal();
        $db->bootEloquent();
    }

    protected function migrateDB()
    {
        DB::schema()->create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('email')->unique();
            $table->timestamps();
        });

        DB::schema()->create('restaurants', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->timestamps();
        });

        DB::schema()->create('images', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->timestamps();
        });

        DB::schema()->create('imageables', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('image_id');
            $table->foreign('image_id')->references('id')->on('imageable')->onDelete('cascade');

            $table->unsignedInteger('imageable_id');
            $table->string('imageable_type');
            $table->boolean('is_featured')->default(0);
            $table->timestamps();
        });
    }
}
