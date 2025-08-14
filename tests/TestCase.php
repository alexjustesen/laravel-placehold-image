<?php

declare(strict_types=1);

namespace AlexJustesen\LaravelPlaceholdImage\Tests;

use AlexJustesen\LaravelPlaceholdImage\LaravelPlaceholdImageServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    protected function setUp(): void
    {
        parent::setUp();
    }

    protected function getPackageProviders($app): array
    {
        return [
            LaravelPlaceholdImageServiceProvider::class,
        ];
    }

    public function getEnvironmentSetUp($app): void
    {
        config()->set('database.default', 'testing');
    }
}
