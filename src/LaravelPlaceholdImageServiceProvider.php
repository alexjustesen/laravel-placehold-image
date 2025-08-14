<?php

declare(strict_types=1);

namespace AlexJustesen\LaravelPlaceholdImage;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class LaravelPlaceholdImageServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('laravel-placehold-image')
            ->hasConfigFile();
    }

    public function packageRegistered(): void
    {
        $this->app->singleton(PlaceholdImage::class, function ($app) {
            $config = $app['config']['placehold-image'] ?? [];

            return new PlaceholdImage(
                null,
                $config['defaults'] ?? []
            );
        });

        $this->app->alias(PlaceholdImage::class, 'placehold-image');
    }
}
