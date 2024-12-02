<?php

use IBroStudio\DataRepository\ValueObjects\Url;

it('can instantiate', function () {
    expect(Url::make('https://ibro.studio/test'))
        ->toBeInstanceOf(Url::class);
});

it('can get scheme', function () {
    $url = Url::make('https://ibro.studio/directory/test?val1=1&val2=2');

    expect($url->getScheme())->toBe('https');
});

it('can get path segments', function () {
    $url = Url::make('https://ibro.studio/directory/test?val1=1&val2=2');

    expect($url->getSegment(1))->toBe('directory')
        ->and($url->getSegment(2))->toBe('test');
});

it('can get query parameters', function () {
    $url = Url::make('https://ibro.studio/directory/test?val1=1&val2=2');

    expect($url->getQuery())->toBe('val1=1&val2=2')
        ->and($url->getQueryParameter('val1'))->toBe('1')
        ->and($url->getQueryParameter('val2'))->toBe('2');
});
