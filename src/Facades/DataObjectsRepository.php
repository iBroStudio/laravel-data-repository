<?php

namespace IBroStudio\DataObjectsRepository\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \IBroStudio\DataObjectsRepository\DataObjectsRepository
 */
class DataObjectsRepository extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \IBroStudio\DataObjectsRepository\DataObjectsRepository::class;
    }
}
