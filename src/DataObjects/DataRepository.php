<?php

namespace IBroStudio\DataRepository\DataObjects;

use IBroStudio\DataRepository\Contracts\Authentication;
use IBroStudio\DataRepository\Models\DataObject;
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

    /*
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
*/
    public static function fromDataObjectModel(DataObject $dataObject): static
    {
        return new static(

        );
    }
}
