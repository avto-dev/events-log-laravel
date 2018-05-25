<?php

namespace AvtoDev\EventsLogLaravel\Tests;

use Illuminate\Foundation\Application;
use AvtoDev\EventsLogLaravel\EventsLogServiceProvider;
use AvtoDev\DevTools\Tests\PHPUnit\AbstractLaravelTestCase;
use AvtoDev\EventsLogLaravel\Tests\Bootstrap\TestsBootstrapper;

/**
 * Class AbstractTestCase.
 */
abstract class AbstractTestCase extends AbstractLaravelTestCase
{
    /**
     * {@inheritdoc}
     */
    protected function beforeApplicationBootstrapped(Application $app)
    {
        $app->useStoragePath(TestsBootstrapper::getStorageDirectoryPath());
    }

    /**
     * {@inheritdoc}
     */
    protected function afterApplicationBootstrapped(Application $app)
    {
        $app->register(EventsLogServiceProvider::class);
    }
}
