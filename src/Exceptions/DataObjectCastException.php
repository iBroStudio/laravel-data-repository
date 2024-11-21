<?php

namespace IBroStudio\DataRepository\Exceptions;

use Exception;
use Throwable;

class DataObjectCastException extends Exception
{
    public function __construct(string $given, string $expected)
    {
        parent::__construct("{$given} is not a {$expected}");
    }
}
