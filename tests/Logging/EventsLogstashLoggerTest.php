<?php

namespace AvtoDev\EventsLogLaravel\Tests\Logging;

use Monolog\Level;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Monolog\Handler\HandlerInterface;
use AvtoDev\EventsLogLaravel\Logging\EventsLogstashLogger;
use AvtoDev\EventsLogLaravel\Logging\Formatters\EventsLogstashFormatter;

/**
 * @group logging
 *
 * @covers \AvtoDev\EventsLogLaravel\Logging\EventsLogstashLogger
 */
class EventsLogstashLoggerTest extends AbstractLoggingTestCase
{
    /**
     * Test factory with default parameters.
     *
     * @todo: Write test with custom parameters
     */
    public function testInstanceCreator(): void
    {
        $config = [
            'formatter'  => [
                'app_name'       => null,
                'system_name'    => null,
                'extra_prefix'   => null,
                'context_prefix' => null,
                'version'        => null,
            ],
            'path'       => $path = storage_path('logs/laravel-events.logstash.log'),
            'level'      => null,
            'bubble'     => null,
            'permission' => null,
            'locking'    => null,
        ];

        $instance = (new EventsLogstashLogger)($config);
        $this->assertInstanceOf(Logger::class, $instance);

        /** @var HandlerInterface|StreamHandler $handler */
        $handler = $instance->getHandlers()[0];
        $this->assertInstanceOf(StreamHandler::class, $handler);
        $this->assertEquals($path, $handler->getUrl());
        $this->assertEquals(Level::Debug, $handler->getLevel());

        $formatter = $handler->getFormatter();
        $this->assertInstanceOf(EventsLogstashFormatter::class, $formatter);
        $this->assertEquals(\gethostname(), $this->getProperty($formatter, 'systemName'));
        $this->assertEquals(
            $this->app->make('config')->get('app.name'),
            $this->getProperty($formatter, 'applicationName')
        );
    }
}
