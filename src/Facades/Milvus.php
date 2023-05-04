<?php

namespace DevelopersSavyour\Milvus\Facades;

use Illuminate\Support\Facades\Facade;

class Milvus extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'milvus';
    }
}
