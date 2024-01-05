<?php

namespace IBroStudio\DataObjectsRepository;

use IBroStudio\DataObjectsRepository\Commands\DataObjectsRepositoryCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class DataObjectsRepositoryServiceProvider extends PackageServiceProvider
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
            ->hasCommand(DataObjectsRepositoryCommand::class)
            ->hasMigration('create_data_objects_repository_table');
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
