<?php

use IBroStudio\DataRepository\ValueObjects\GitSshUrl;
use Illuminate\Validation\ValidationException;

it('can instantiate GitSshUrl object value', function () {
    expect(
        GitSshUrl::from('git@github.com:iBroStudio/laravel-data-repository.git')
    )->toBeInstanceOf(GitSshUrl::class);
});

it('can validate GitSshUrl object value', function () {
    GitSshUrl::from('https://github.com/iBroStudio/laravel-data-repository.git');
})->throws(ValidationException::class);

it('can return GitSshUrl object value', function () {
    $url = 'git@github.com:iBroStudio/laravel-data-repository.git';

    expect(
        GitSshUrl::from($url)->value
    )->toEqual($url);
});

it('can return GitSshUrl object value single property', function () {
    $url = GitSshUrl::from('git@github.com:iBroStudio/laravel-data-repository.git');

    expect($url->provider)->toEqual('github')
        ->and($url->username)->toEqual('iBroStudio')
        ->and($url->repository)->toEqual('laravel-data-repository');
});

it('can return GitSshUrl object value properties', function () {
    $url = 'git@github.com:iBroStudio/laravel-data-repository.git';

    expect(
        GitSshUrl::from($url)
            ->properties()
    )->toMatchArray([
        'value' => $url,
        'username' => 'iBroStudio',
        'repository' => 'laravel-data-repository',
        'provider' => 'github',
    ]);
});
