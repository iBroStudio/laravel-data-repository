<?php

use IBroStudio\DataRepository\Tests\Support\DataObjects\WithEncryptableTextData;
use IBroStudio\DataRepository\ValueObjects\EncryptableText;

it('can build dto casting EncryptableText property', function () {
    $data = new WithEncryptableTextData(
        name: fake()->name(),
        secret: EncryptableText::make(fake()->word())
    );

    expect($data)->toBeInstanceOf(WithEncryptableTextData::class);

    expect($data->secret)->toBeInstanceOf(EncryptableText::class);
});
