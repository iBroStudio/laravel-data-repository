<?php

use IBroStudio\DataRepository\ValueObjects\GitSshUrl;
use Illuminate\Validation\ValidationException;

it('can instantiate', function () {
    $url = GitSshUrl::make('git@github.com:iBroStudio/laravel-data-repository.git');

    expect($url)->toBeInstanceOf(GitSshUrl::class);
});

it('validate value', function () {
    GitSshUrl::make('https://github.com/iBroStudio/laravel-data-repository.git');
})->throws(ValidationException::class);

it('can retrieve the value', function () {
    $url = 'git@github.com:iBroStudio/laravel-data-repository.git';
    $vo = GitSshUrl::make('git@github.com:iBroStudio/laravel-data-repository.git');
    expect($vo->value())->toEqual($url);
});

it('can retrieve split values', function () {
    $url = GitSshUrl::make('git@github.com:iBroStudio/laravel-data-repository.git');

    expect($url->provider())->toEqual('github')
        ->and($url->username())->toEqual('iBroStudio')
        ->and($url->repository())->toEqual('laravel-data-repository');
});

it('can convert value items into array', function () {
    $url = GitSshUrl::make('git@github.com:iBroStudio/laravel-data-repository.git');

    expect($url->toArray())->toMatchArray([
        'url' => 'git@github.com:iBroStudio/laravel-data-repository.git',
        'username' => 'iBroStudio',
        'repository' => 'laravel-data-repository',
        'provider' => 'github',
    ]);
});
