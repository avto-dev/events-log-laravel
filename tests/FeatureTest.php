<?php

namespace AvtoDev\EventsLogLaravel\Tests;

use Illuminate\Foundation\Application;
use Illuminate\Config\Repository as ConfigRepository;
use AvtoDev\EventsLogLaravel\Events\AbstractLoggableEvent;

/**
 * @coversNothing
 */
class FeatureTest extends AbstractTestCase
{
    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->clearLaravelLogs();
    }

    protected function afterBootstrap(Application $app): void
    {
        /** @var ConfigRepository $config */
        $config = $app->make('config');

        $config->set('logging.channels.' . $channel_name = 'events-stack', [
            'driver'   => 'stack',
            'channels' => ['events-monolog', 'events-logstash'],
        ]);

        $config->set('logging.channels.events-monolog', [
            'driver' => 'single',
            'path'   => storage_path('logs/laravel-events.log'),
            'level'  => 'debug',
        ]);

        $config->set('logging.channels.events-logstash', [
            'driver' => 'custom',
            'via'    => \AvtoDev\EventsLogLaravel\Logging\EventsLogstashLogger::class,
            'path'   => storage_path('logs/logstash/laravel-events.log'),
            'level'  => 'debug',
        ]);

        $config->set('logging.events_channel', $channel_name);

        parent::afterBootstrap($app);
    }

    /**
     * Feature test for a writing log message format.
     *
     * @return void
     */
    public function testWriting(): void
    {
        event(new class extends AbstractLoggableEvent
        {
            public function logMessage(): string
            {
                return 'foo message';
            }
        });

        $this->assertLogFileContains('"source":"UNKNOWN"', $events_log = 'laravel-events.log');
        $this->assertLogFileContains('"type":"UNKNOWN"', $events_log);
        $this->assertLogFileContains('"name":"class@anonymous', $events_log);
        $this->assertLogFileContains($this->app->environment() . '.INFO: foo message', $events_log);

        $this->assertLogFileContains('"entry_type":"event"', $events_logstash_log = 'logstash/laravel-events.log');
        $this->assertLogFileContains('"name":"class@anonymous', $events_logstash_log);
        $this->assertLogFileContains('"level":"INFO"', $events_logstash_log);
        $this->assertLogFileContains('"event":{', $events_logstash_log);
        $this->assertLogFileContains('"message":"foo message"', $events_logstash_log);
    }
}
