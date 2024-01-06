<?php

namespace IBroStudio\DataRepository;

use IBroStudio\DataRepository\Commands\DataRepositoryCommand;
use MichaelRubel\ValueObjects\Collection\Complex\Email;
use MichaelRubel\ValueObjects\Collection\Complex\FullName;
use MichaelRubel\ValueObjects\Collection\Complex\TaxNumber;
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
            ->hasMigration('create_data_repository_table');
    }

    public function packageRegistered()
    {
        $this->registerValueObjectMacros();
    }

    protected function registerValueObjectMacros()
    {
        ValueObject::macro('toJson', function () {

            return match(get_class($this)) {
                Email::class => json_encode(['value' => $this->value()]),
                FullName::class => json_encode(['value' => $this->value()]),
                TaxNumber::class => json_encode(['number' => $this->value()]),
                default => json_encode($this->toArray())
            };
        });
    }
}

/*
TaxNumber::macro('toJson', function () {
            return json_encode(['number' => $this->value()]);
        });

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
