<?php

namespace AvtoDev\EventsLogLaravel\Tests\Logging;

use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Monolog\Handler\HandlerInterface;
use Monolog\Formatter\LogstashFormatter;
use AvtoDev\EventsLogLaravel\Tests\AbstractTestCase;
use AvtoDev\EventsLogLaravel\Logging\DefaultLogstashLogger;

/**
 * @group logging
 */
class DefaultLogstashLoggerTest extends AbstractTestCase
{
    /**
     * Test factory with default parameters.
     *
     * @return void
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
            'path'       => $path = storage_path('logs/laravel.logstash.log'),
            'level'      => null,
            'bubble'     => null,
            'permission' => null,
            'locking'    => null,
        ];

        /** @var Logger $instance */
        $instance = (new DefaultLogstashLogger)($config);
        $this->assertInstanceOf(Logger::class, $instance);

        /** @var HandlerInterface|StreamHandler $handler */
        $handler = $instance->getHandlers()[0];
        $this->assertInstanceOf(StreamHandler::class, $handler);
        $this->assertEquals($path, $handler->getUrl());
        $this->assertEquals(Logger::DEBUG, $handler->getLevel());

        $formatter = $handler->getFormatter();
        $this->assertInstanceOf(LogstashFormatter::class, $formatter);
        $this->assertEquals(\gethostname(), $this->getProperty($formatter, 'systemName'));
        $this->assertEquals(
            $this->app->make('config')->get('app.name'),
            $this->getProperty($formatter, 'applicationName')
        );
    }
}
