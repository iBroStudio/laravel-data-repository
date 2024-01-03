<?php

use IBroStudio\DataObjectsRepository\Tests\Support\DataObjects\WithEncryptableTextData;
use IBroStudio\DataObjectsRepository\ValueObjects\EncryptableText;

it('can build dto casting EncryptableText property', function () {
    $data = new WithEncryptableTextData(
        name: fake()->name(),
        secret: EncryptableText::make(fake()->word())
    );

    expect($data)->toBeInstanceOf(WithEncryptableTextData::class);

    expect($data->secret)->toBeInstanceOf(EncryptableText::class);
});
