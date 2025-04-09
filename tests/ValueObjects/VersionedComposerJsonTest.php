<?php

use IBroStudio\DataRepository\ValueObjects\SemanticVersion;
use IBroStudio\DataRepository\ValueObjects\VersionedComposerJson;
use Illuminate\Validation\ValidationException;

it('can instantiate', function () {
    expect(
        VersionedComposerJson::from(__DIR__.'/../Support/composer.json')
    )->toBeInstanceOf(VersionedComposerJson::class);
});

it('throws exception when empty value', function () {
    VersionedComposerJson::from('');
})->throws(ValidationException::class);

it('throws exception when file does not exist', function () {
    VersionedComposerJson::from('does_not_exist.json');
})->throws(ValidationException::class, 'File not found: does_not_exist.json');

it('can give composer.json version', function () {
    expect(
        VersionedComposerJson::from(__DIR__.'/../Support/composer.json')->version()
    )->toBeInstanceOf(SemanticVersion::class);
});

it('can update composer.json version', function () {
    $version = SemanticVersion::from(fake()->semver());
    expect(
        VersionedComposerJson::from(__DIR__.'/../Support/composer.json')->version($version)
    )->toEqual($version);
});

it('can retrieve the scripts section', function () {
    expect(
        VersionedComposerJson::from(__DIR__.'/../Support/composer.json')->scripts()
    )->toBeArray();
});

it('can retrieve a script line', function () {
    expect(
        VersionedComposerJson::from(__DIR__.'/../Support/composer.json')->script('test')
    )->toEqual('vendor/bin/pest')
        ->and(
            VersionedComposerJson::from(__DIR__.'/../Support/composer.json')->script('does_not_exist')
        )->toBeNull();
});
