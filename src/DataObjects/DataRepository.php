<?php

namespace IBroStudio\DataRepository\DataObjects;

use IBroStudio\DataRepository\Models\DataObject;
use MichaelRubel\ValueObjects\ValueObject;
use Spatie\LaravelData\Data;

abstract class DataRepository extends Data
{
    public static function fromArray(array $data): static
    {
        $class = new \ReflectionClass(static::class);
        $constructor = $class->getConstructor();
        $parameters = collect($constructor->getParameters());

        foreach ($data as $key => $value) {
            $parameter = $parameters->where('name', $key)->first();
            if ($parameter === null) {
                unset($data[$key]);
            } else {
                $type = $parameter->getType()->getName();
                if (is_a($type, ValueObject::class, true)) {
                    $data[$key] = $type::make(...(array) $value);
                }
            }
        }

        return new static(...$data);
    }

    public static function fromDataObjectModel(DataObject $dataObject): static
    {
        return new static(

        );
    }
}
