<?php

namespace parzival42codes\LaravelExtendedException;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class LaravelExtendedExceptionServiceProvider extends PackageServiceProvider
{
    public const PACKAGE_NAME = 'laravel-extended-exception';

    public const PACKAGE_NAME_SHORT = 'extended-exception';

    public function configurePackage(Package $package): void
    {
        $package->name(self::PACKAGE_NAME)->hasViews()->hasRoute('route');
    }

    public function registeringPackage(): void
    {
    }
}
