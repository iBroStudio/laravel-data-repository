<?php

namespace IBroStudio\DataRepository;

use IBroStudio\DataRepository\Commands\DataRepositoryCommand;
use MichaelRubel\ValueObjects\ValueObject;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class DataRepositoryServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('laravel-data-objects-repository')
            ->hasCommand(DataRepositoryCommand::class)
            ->hasMigration('create_data_objects_repository_table');
    }

    public function packageRegistered()
    {
        ValueObject::macro('toJson', function () {
            return json_encode($this->toArray());
        });
    }
}

/*
->hasInstallCommand(function(InstallCommand $command) {
    $command
        ->publishConfigFile()
        ->publishAssets()
        ->publishMigrations()
        ->askToRunMigrations()
        ->copyAndRegisterServiceProviderInApp()
        ->askToStarRepoOnGitHub('your-vendor/your-repo-name')
            });
*/
