<?php

namespace Fidum\Skeleton;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Fidum\Skeleton\Skeleton
 */
class SkeletonFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'skeleton';
    }
}
