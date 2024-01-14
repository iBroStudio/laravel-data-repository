<?php

use IBroStudio\DataRepository\Casts\AuthenticationCast;
use IBroStudio\DataRepository\Contracts\Authentication;
use IBroStudio\DataRepository\Transformers\AuthenticationTransformer;
use IBroStudio\DataRepository\Transformers\EncryptableTextTransformer;
use IBroStudio\DataRepository\ValueObjects\EncryptableText;

return [
    'casts' => [
        Authentication::class => AuthenticationCast::class,
    ],

    'transformers' => [
        EncryptableText::class => EncryptableTextTransformer::class,
        Authentication::class => AuthenticationTransformer::class,
    ],
];
