<?php

namespace AvtoDev\EventsLogLaravel\Tests;

use ReflectionClass;
use ReflectionException;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Foundation\Application;
use Illuminate\Contracts\Console\Kernel;
use AvtoDev\EventsLogLaravel\ServiceProvider;

abstract class AbstractTestCase extends \Illuminate\Foundation\Testing\TestCase
{
    /**
     * Creates the application.
     *
     * @return Application
     */
    public function createApplication()
    {
        /** @var Application $app */
        $app = require __DIR__ . '/../vendor/laravel/laravel/bootstrap/app.php';

        $this->beforeBootstrap($app);

        $app->make(Kernel::class)->bootstrap();

        $this->afterBootstrap($app);

        return $app;
    }

    protected function getStoragePath(): string
    {
        return __DIR__ . '/temp/storage';
    }

    /**
     * @param Application $app
     *
     * @return void
     */
    protected function beforeBootstrap(Application $app): void
    {
        $app->useStoragePath($this->getStoragePath());
    }

    /**
     * @param Application $app
     *
     * @return void
     */
    protected function afterBootstrap(Application $app): void
    {
        putenv('EVENTS_LOG_CHANNEL=default');

        $app->register(ServiceProvider::class);
    }

    /**
     * Clean laravel logs directory.
     *
     * @return void
     */
    protected function clearLaravelLogs(): void
    {
        (new Filesystem)->cleanDirectory($this->getStoragePath() . '/logs');
    }

    /**
     * @param string $file
     *
     * @return void
     */
    protected function assertLogFileNotExists(string $file = 'laravel.log'): void
    {
        $this->assertFileNotExists($this->getStoragePath() . "/logs/{$file}");
    }

    /**
     * @param string $file
     *
     * @return void
     */
    protected function assertLogFileExists(string $file = 'laravel.log'): void
    {
        $this->assertFileExists($this->getStoragePath() . "/logs/{$file}");
    }

    /**
     * @param string $what
     * @param string $file
     *
     * @return void
     */
    protected function assertLogFileContains(string $what, string $file = 'laravel.log'): void
    {
        $this->assertStringContainsString($what, \file_get_contents($this->getStoragePath() . "/logs/{$file}"));
    }

    /**
     * Get a instance property (public/private/protected) value.
     *
     * @param object $object
     * @param string $property_name
     *
     * @throws ReflectionException
     *
     * @return mixed
     */
    protected function getProperty($object, string $property_name)
    {
        $reflection = new ReflectionClass($object);

        $property = $reflection->getProperty($property_name);
        $property->setAccessible(true);

        return $property->getValue($object);
    }
}
