<?php

use IBroStudio\DataRepository\Transformers\EncryptableTextTransformer;
use IBroStudio\DataRepository\ValueObjects\EncryptableText;

return [
    'transformers' => [
        EncryptableText::class => EncryptableTextTransformer::class,
    ],
];
