<?php

namespace Developerssavyour\LaravelMilvus\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Developerssavyour\LaravelMilvus\Skeleton\SkeletonClass
 */
class MilvusFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'laravel-milvus';
    }
}
