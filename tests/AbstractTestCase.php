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
     * Make default channel setup?
     *
     * @var bool
     */
    protected $setup_default_channel = true;

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
        if ($this->setup_default_channel === true) {
            putenv('EVENTS_LOG_CHANNEL=default');
        }

        $app->register(EventsLogServiceProvider::class);
    }
}
