<?php

namespace LuigiBittencourtMarzinotto\RDStation;

use LuigiBittencourtMarzinotto\RDStation\Commands\RDStationCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class RDStationServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('rdstation')
            ->hasConfigFile()
            ->hasMigration('create_rdstation_table')
            ->hasCommand(RDStationCommand::class);
    }
}
