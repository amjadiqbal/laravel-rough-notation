<?php

namespace AmjadIqbal\RoughNotation\Tests;

use Orchestra\Testbench\TestCase as BaseTestCase;
use AmjadIqbal\RoughNotation\NotationServiceProvider;

class TestCase extends BaseTestCase
{
    protected function getPackageProviders($app)
    {
        return [NotationServiceProvider::class];
    }
}
