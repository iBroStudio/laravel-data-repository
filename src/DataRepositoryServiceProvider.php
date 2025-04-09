<?php

namespace IBroStudio\DataRepository;

use IBroStudio\DataRepository\Commands\DataRepositoryInstallCommand;
use Illuminate\Support\Facades\Config;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class DataRepositoryServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('laravel-data-repository')
            ->hasCommand(DataRepositoryInstallCommand::class)
            ->hasMigration('create_data_repository_table')
            ->hasConfigFile()
            ->hasTranslations();
    }

    public function packageBooted(): void
    {
        Config::set('data', array_merge_recursive(
            require __DIR__.'/../config/spatie-data.php',
            Config::get('data') ?? []
        ));
    }
}
