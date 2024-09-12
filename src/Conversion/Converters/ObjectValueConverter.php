<?php

namespace IBroStudio\DataRepository\Conversion\Converters;

use IBroStudio\DataRepository\Conversion\BaseConverter;
use IBroStudio\DataRepository\Exceptions\PropertyConversionFailedException;
use MichaelRubel\ValueObjects\ValueObject;
use ReflectionClass;
use ReflectionProperty;

class ObjectValueConverter extends BaseConverter
{
    public function validate(ReflectionClass $reflection, ReflectionProperty $property): bool
    {
        return $reflection->isSubclassOf(ValueObject::class);
    }

    public function convert(ReflectionClass $reflection, ReflectionProperty $property, mixed $data): mixed
    {
        try {
            return $reflection->newInstanceWithoutConstructor()
                ->make($data);
        } catch (\Exception $e) {
            throw new PropertyConversionFailedException($e->getMessage());
        }
    }
}
