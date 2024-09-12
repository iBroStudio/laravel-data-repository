<?php

namespace IBroStudio\DataRepository\Conversion;

use Closure;
use IBroStudio\DataRepository\Contracts\Converter;
use ReflectionClass;
use ReflectionProperty;

abstract class BaseConverter implements Converter
{
    abstract public function validate(ReflectionClass $reflection, ReflectionProperty $property): bool;

    abstract public function convert(ReflectionClass $reflection, ReflectionProperty $property, mixed $data): mixed;

    public function handle(DataPropertiesConverter $manager, Closure $next): mixed
    {
        $manager->processThroughConverter($this);

        return $next($manager);
    }
}
