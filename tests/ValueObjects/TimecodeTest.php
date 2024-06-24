<?php

use IBroStudio\DataRepository\ValueObjects\Timecode;

it('can instantiate from string', function () {
    $timecode = Timecode::make(fake()->time('H:i:s:v'));

    expect($timecode)->toBeInstanceOf(Timecode::class);
});

it('can instantiate from float', function () {
    $timecode = Timecode::make(microtime(true));

    expect($timecode)->toBeInstanceOf(Timecode::class);
});

it('can give a well formated timecode', function () {
    $timecode = Timecode::make('5:4:2:4545');

    expect($timecode->value())->toEqual('05:04:02.454500');
});
