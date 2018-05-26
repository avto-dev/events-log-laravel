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
    use Traits\LogFilesAssertsTrait;

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
        putenv('EVENTS_LOG_CHANNEL=default');

        $app->register(EventsLogServiceProvider::class);
    }
}
