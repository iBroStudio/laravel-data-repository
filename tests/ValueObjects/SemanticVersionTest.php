<?php

use IBroStudio\DataRepository\Enums\SemanticVersionSegments;
use IBroStudio\DataRepository\ValueObjects\SemanticVersion;

it('can instantiate', function () {
    $version = SemanticVersion::make(fake()->semver());

    expect($version)->toBeInstanceOf(SemanticVersion::class);
});

it('can give a well formated version', function () {
    $version = fake()->semver();
    $valueObject = SemanticVersion::make($version);

    expect($valueObject->value())->toEqual($version);
});

it('can handle prefix', function () {
    $version = 'v.'.fake()->semver();
    $valueObject = SemanticVersion::make($version);

    expect($valueObject->value())->toEqual($version);
});

it('can give prefixed version without prefix', function () {
    $version = fake()->semver();
    $prefix = 'v.';
    $valueObject = SemanticVersion::make($prefix.$version);

    expect($valueObject->withoutPrefix()->value())->toEqual($version);
});

it('can increment major segment', function () {
    $version = SemanticVersion::make('1.0.0');
    $version->increment(SemanticVersionSegments::MAJOR);

    expect($version->value())->toEqual('2.0.0');
});

it('can increment minor segment', function () {
    $version = SemanticVersion::make('1.0.0');
    $version->increment(SemanticVersionSegments::MINOR);

    expect($version->value())->toEqual('1.1.0');
});

it('can increment patch segment', function () {
    $version = SemanticVersion::make('1.0.0');
    $version->increment(SemanticVersionSegments::PATCH);

    expect($version->value())->toEqual('1.0.1');
});
