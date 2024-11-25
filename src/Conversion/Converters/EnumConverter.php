<?php

namespace IBroStudio\DataRepository\Conversion\Converters;

use IBroStudio\DataRepository\Conversion\BaseConverter;
use IBroStudio\DataRepository\Exceptions\PropertyConversionFailedException;
use ReflectionClass;
use ReflectionMethod;
use ReflectionProperty;

class EnumConverter extends BaseConverter
{
    public function validate(ReflectionClass $reflection, ReflectionProperty $property): bool
    {
        return $reflection->isEnum();
    }

    public function convert(ReflectionClass $reflection, ReflectionProperty $property, mixed $data): mixed
    {
        if (is_object($data) && enum_exists(get_class($data))) {
            return $data;
        }

        try {
            return (new ReflectionMethod($reflection->getname(), 'tryFrom'))
                ->invoke(null, $data)
                ?? constant("{$reflection->getname()}::$data");
        } catch (\Exception $e) {
            throw new PropertyConversionFailedException($e->getMessage());
        }
    }
}
