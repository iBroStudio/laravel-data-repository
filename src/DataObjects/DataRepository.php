<?php

namespace IBroStudio\DataRepository\DataObjects;

use IBroStudio\DataRepository\Contracts\Authentication;
use Illuminate\Support\Collection;
use MichaelRubel\ValueObjects\ValueObject;
use Spatie\LaravelData\Data;

abstract class DataRepository extends Data
{
    public function convertValueObjects()
    {
        $class = new \ReflectionClass(static::class);
        $properties = $class->getProperties(\ReflectionProperty::IS_PUBLIC);
        $data = new Collection();

        foreach ($properties as $property) {
            if (is_a($this->{$property->name}, ValueObject::class)) {
                if (is_a($this->{$property->name}, Authentication::class)) {
                    $data = $data->merge($this->{$property->name}->toDecryptedArray());
                } else {
                    $data = $data->merge($this->{$property->name}->toArray());
                }
            } else {
                $data->put($property->name, $this->{$property->name});
            }
        }

        return $data;
    }
}
