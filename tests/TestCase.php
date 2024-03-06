<?php

namespace Larawatch\Logger\Tests;

use Larawatch\Logger\LarawatchServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{

    protected function getPackageProviders($app)
    {
        return [
            LarawatchServiceProvider::class,
        ];
    }

}
