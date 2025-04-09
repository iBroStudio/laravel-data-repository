<?php

use IBroStudio\DataRepository\Contracts\Authentication;
use IBroStudio\DataRepository\DataCasts\AuthenticationCast;
use IBroStudio\DataRepository\DataCasts\EncryptedTextCast;
use IBroStudio\DataRepository\Transformers\AuthenticationTransformer;
use IBroStudio\DataRepository\Transformers\EncryptableTextTransformer;
use IBroStudio\DataRepository\ValueObjects\EncryptableText;

return [
    'casts' => [
        Authentication::class => AuthenticationCast::class,
        EncryptableText::class => EncryptedTextCast::class,
    ],

    'transformers' => [
        Authentication::class => AuthenticationTransformer::class,
        EncryptableText::class => EncryptableTextTransformer::class,
    ],
];
