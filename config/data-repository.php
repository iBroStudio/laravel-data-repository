<?php

use IBroStudio\DataRepository\Conversion\Converters\EnumConverter;
use IBroStudio\DataRepository\Conversion\Converters\LaravelDataCollectionConverter;
use IBroStudio\DataRepository\Conversion\Converters\LaravelDataConverter;
use IBroStudio\DataRepository\Conversion\Converters\ObjectValueConverter;

return [

    'properties_converters' => [
        ObjectValueConverter::class,
        LaravelDataConverter::class,
        LaravelDataCollectionConverter::class,
        EnumConverter::class,
    ],

];
