<?php

namespace IBroStudio\DataRepository\Concerns;

use IBroStudio\DataRepository\Conversion\DataPropertiesConverter;

trait ConvertiblesDataProperties
{
    public static function fromConverters(array $data): self
    {
        return new self(
            ...(new DataPropertiesConverter(self::class))->convert($data)
        );
    }
}
