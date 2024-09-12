<?php

namespace IBroStudio\DataRepository\Conversion;

use IBroStudio\DataRepository\Contracts\Converter;
use IBroStudio\DataRepository\Exceptions\MissingConverterException;
use ReflectionAttribute;
use ReflectionClass;
use ReflectionProperty;

class DataPropertiesMapper
{
    private Converter $converter;

    public function trough(Converter $converter): self
    {
        $this->converter = $converter;

        return $this;
    }

    public function mapProperty(ReflectionProperty $property, ReflectionClass $reflection): ?array
    {
        if (! isset($this->converter)) {
            throw new MissingConverterException();
        }

        if ($this->converter->validate($reflection, $property)) {
            return [
                'converter' => $this->converter::class,
                'object' => $reflection->getName(),
                'attribute' => collect($property->getAttributes())
                    ->mapWithKeys(function (ReflectionAttribute $attribute) {
                        return [
                            'name' => $attribute->getName(),
                            'arguments' => $attribute->getArguments(),
                        ];
                    })->toArray(),
            ];
        }

        return null;
    }
}
