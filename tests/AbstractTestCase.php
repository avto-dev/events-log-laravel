<?php

namespace AvtoDev\EventsLogLaravel\Tests;

use AvtoDev\DevTools\Tests\PHPUnit\AbstractLaravelTestCase;
use Illuminate\Foundation\Application;
use AvtoDev\EventsLogLaravel\EventsLogServiceProvider;
use AvtoDev\EventsLogLaravel\Tests\Bootstrap\TestsBootstrapper;

class AbstractTestCase extends AbstractLaravelTestCase
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
        putenv('EVENTS_LOG_CHANNEL=default');

        $app->register(EventsLogServiceProvider::class);
    }
}
