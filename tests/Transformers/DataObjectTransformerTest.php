<?php

use IBroStudio\DataRepository\Tests\Support\DataObjects\OtherReferableData;
use IBroStudio\DataRepository\Tests\Support\DataObjects\WithTransformableData;

it('can transform data object', function () {
    $word1 = fake()->word();
    $word2 = fake()->word();
    $data = new WithTransformableData(
        name: $word1,
        otherData: new OtherReferableData($word2)
    );

    expect($data->toArray())->toMatchArray([
        'name' => $word1,
        'otherData' => $word2,
    ]);
});
