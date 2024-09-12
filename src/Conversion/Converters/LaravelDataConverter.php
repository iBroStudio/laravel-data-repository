<?php

namespace IBroStudio\DataRepository\Conversion\Converters;

use IBroStudio\DataRepository\Conversion\BaseConverter;
use IBroStudio\DataRepository\Exceptions\PropertyConversionFailedException;
use ReflectionClass;
use ReflectionProperty;
use Spatie\LaravelData\Data;

class LaravelDataConverter extends BaseConverter
{
    public function validate(ReflectionClass $reflection, ReflectionProperty $property): bool
    {
        return $reflection->isSubclassOf(Data::class);
    }

    public function convert(ReflectionClass $reflection, ReflectionProperty $property, mixed $data): mixed
    {
        try {
            return $reflection->newInstanceWithoutConstructor()
                ->from($data);
        } catch (\Exception $e) {
            throw new PropertyConversionFailedException($e->getMessage());
        }
    }
}
