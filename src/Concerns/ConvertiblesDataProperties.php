<?php

namespace IBroStudio\DataRepository\Concerns;

use IBroStudio\DataRepository\Conversion\DataPropertiesConverter;

trait ConvertiblesDataProperties
{
    public static function fromConverters(array $data): static
    {
        // @phpstan-ignore-next-line
        return new static(
            ...(new DataPropertiesConverter(self::class))->convert($data)
        );
    }
}
