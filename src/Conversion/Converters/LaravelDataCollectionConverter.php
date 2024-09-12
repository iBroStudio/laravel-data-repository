<?php

namespace IBroStudio\DataRepository\Conversion\Converters;

use IBroStudio\DataRepository\Concerns\CanHaveReflectionFromAttributes;
use IBroStudio\DataRepository\Conversion\BaseConverter;
use IBroStudio\DataRepository\Exceptions\PropertyConversionFailedException;
use Illuminate\Support\Collection;
use ReflectionClass;
use ReflectionProperty;
use Spatie\LaravelData\Data;

class LaravelDataCollectionConverter extends BaseConverter
{
    use CanHaveReflectionFromAttributes;

    public function validate(ReflectionClass $reflection, ReflectionProperty $property): bool
    {
        if ($reflection->getName() !== Collection::class) {
            return false;
        }

        return $this->getReflectionFromAttributes($property->getAttributes())
            ->isSubclassOf(Data::class);
    }

    public function convert(ReflectionClass $reflection, ReflectionProperty $property, mixed $data): mixed
    {
        try {
            return collect(
                $this->getReflectionFromAttributes($property->getAttributes())
                    ->newInstanceWithoutConstructor()
                    ->collect($data)
            );
        } catch (\Exception $e) {
            throw new PropertyConversionFailedException($e->getMessage());
        }
    }
}
