<?php

namespace AvtoDev\EventsLogLaravel\Tests\Traits;

use Illuminate\Filesystem\Filesystem;
use AvtoDev\EventsLogLaravel\Tests\Bootstrap\TestsBootstrapper;

/**
 * Trait LogFilesAssertsTrait.
 *
 * @mixin \PHPUnit\Framework\TestCase
 */
trait LogFilesAssertsTrait
{
    /**
     * Make logs directory cleaning (remove all files and directories inside).
     *
     * @return void
     */
    public function clearLog(): void
    {
        $files = new Filesystem;

        $files->cleanDirectory($path = TestsBootstrapper::getStorageDirectoryPath() . '/logs');
        $files->put($path . '/laravel.log', null);
    }

    /**
     * Assert that log file contains passed substring.
     *
     * @param string $substring
     * @param string $file
     *
     * @return void
     */
    public function assertLogFileContains(string $substring, string $file = 'laravel.log'): void
    {
        $content = $this->getLogFileContent($file);

        $this->assertContains($substring, $content, "Log file [{$file}] does not contains [{$substring}]");
    }

    /**
     * Assert that log file NOT contains passed substring.
     *
     * @param string $substring
     * @param string $file
     *
     * @return void
     */
    public function assertLogFileNotContains(string $substring, string $file = 'laravel.log'): void
    {
        $content = $this->getLogFileContent($file);

        $this->assertNotContains($substring, $content, "Log file [{$file}] contains [{$substring}]");
    }

    /**
     * Get the log file content.
     *
     * @param string $file
     *
     * @return bool|string
     */
    protected function getLogFileContent(string $file = 'laravel.log')
    {
        $file_path = TestsBootstrapper::getStorageDirectoryPath() . '/logs/' . ltrim($file, '\\\/');

        return file_get_contents($file_path);
    }
}
