<?php

namespace IBroStudio\DataRepository\Conversion;

use IBroStudio\DataRepository\Contracts\Converter;
use Illuminate\Pipeline\Pipeline;
use Illuminate\Support\Collection;
use ReflectionClass;
use ReflectionException;
use ReflectionNamedType;
use ReflectionProperty;
use ReflectionUnionType;
use Spatie\LaravelData\Optional;

class DataPropertiesConverter
{
    public Collection $properties;

    public Collection $data;

    public Collection $map;

    protected DataPropertiesMapper $mapper;

    public function __construct(string $dataClass)
    {
        $this->properties = collect(
            (new ReflectionClass($dataClass))
                ->getProperties(ReflectionProperty::IS_PUBLIC)
        );

        $this->map = new Collection();

        $this->mapper = new DataPropertiesMapper();
    }

    public function convert(array $data): array|Collection
    {
        $this->data = collect($data);

        return app(Pipeline::class)
            ->send($this)
            ->through(config('data-repository.properties_converters'))
            ->thenReturn()
            ->data;
    }

    public function processThroughConverter(Converter $converter): self
    {
        //dd($this->properties);
        $this->properties->each(function (ReflectionProperty $property, int $key) use ($converter) {

            $type = $property->getType();

            if ($type instanceof ReflectionUnionType) {
                // @phpstan-ignore-next-line
                foreach ($property->getType()->getTypes() as $unionType) {
                    if ($unionType->getName() !== Optional::class) {
                        $type = $unionType;
                    }
                }
            }

            $reflection = $this->getReflection($type);

            if ($reflection instanceof ReflectionClass) {
                $mapped_property = $this->map->get($property->getName(), function () use ($property, $converter, $reflection) {
                    return $this->mapper
                        ->trough($converter)
                        ->mapProperty($property, $reflection);
                });

                if (! is_null($mapped_property) && $mapped_property['converter'] === $converter::class) {
                    $this->data->put(
                        $property->getName(),
                        $converter->convert(
                            reflection: $reflection,
                            property: $property,
                            data: $this->data->get($property->getName())
                        )
                    );

                    $this->properties->pull($key);
                }
            } else {
                $this->properties->pull($key);
            }
        });

        return $this;
    }

    private function getReflection(ReflectionNamedType $type): ?ReflectionClass
    {
        try {
            return new ReflectionClass($type->getName());
        } catch (ReflectionException $e) {
            return null;
        }
    }
}
