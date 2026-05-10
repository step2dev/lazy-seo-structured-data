<?php

namespace Step2dev\LazySeoStructuredData\Tests;

use Orchestra\Testbench\TestCase as Orchestra;
use Step2dev\LazySeoStructuredData\LazySeoStructuredDataServiceProvider;

class TestCase extends Orchestra
{
    protected function getPackageProviders($app): array
    {
        return [
            LazySeoStructuredDataServiceProvider::class,
        ];
    }
}
