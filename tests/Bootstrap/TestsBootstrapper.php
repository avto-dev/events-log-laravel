<?php

namespace AvtoDev\EventsLogLaravel\Tests\Bootstrap;

use AvtoDev\DevTools\Tests\PHPUnit\Traits\CreatesApplicationTrait;
use AvtoDev\DevTools\Tests\Bootstrap\AbstractLaravelTestsBootstrapper;

class TestsBootstrapper extends AbstractLaravelTestsBootstrapper
{
    use CreatesApplicationTrait;

    /**
     * Returns `storage` directory path.
     *
     * @return string
     */
    public static function getStorageDirectoryPath()
    {
        return __DIR__ . '/../temp/storage';
    }

    /**
     * Prepare `storage` directory for tests.
     *
     * @return bool
     */
    protected function bootPrepareStorageDirectory()
    {
        $this->log('Prepare storage directory');

        if ($this->files->isDirectory($storage = static::getStorageDirectoryPath())) {
            if ($this->files->deleteDirectory($storage)) {
                $this->log('Previous storage directory deleted successfully');
            } else {
                $this->log(sprintf('Cannot delete directory "%s"', $storage));

                return false;
            }
        }

        $this->files->copyDirectory(__DIR__ . '/../../vendor/laravel/laravel/storage', $storage);

        return true;
    }
}
