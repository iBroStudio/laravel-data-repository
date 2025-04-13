<?php

namespace IBroStudio\DataRepository\DataObjects;

use IBroStudio\DataRepository\Concerns\ConvertiblesDataProperties;
use IBroStudio\DataRepository\ValueObjects\ValueObject;
use Illuminate\Support\Collection;
use Spatie\LaravelData\Data;

abstract class DataRepository extends Data
{
    use ConvertiblesDataProperties;

    public function convertValueObjects(): Collection
    {
        $class = new \ReflectionClass(static::class);
        $properties = $class->getProperties(\ReflectionProperty::IS_PUBLIC);
        $data = new Collection;

        foreach ($properties as $property) {
            if (is_a($this->{$property->name}, ValueObject::class)) {
                $data = $data->merge($this->{$property->name}->toArray());
            } else {
                $data->put($property->name, $this->{$property->name});
            }
        }

        return $data;
    }
}
