<?php

declare(strict_types = 1);

namespace AvtoDev\EventsLogLaravel\Tests\Logging;

use Monolog\Logger;
use InvalidArgumentException;
use Monolog\Handler\HandlerInterface;
use AvtoDev\EventsLogLaravel\Logging\Handlers\UdpHandler;
use AvtoDev\EventsLogLaravel\Logging\EventsUdpLogstashLogger;
use AvtoDev\EventsLogLaravel\Logging\Formatters\EventsLogstashFormatter;

/**
 * @group logging
 *
 * @covers \AvtoDev\EventsLogLaravel\Logging\EventsUdpLogstashLogger
 */
class EventsUdpLogstashLoggerTest extends AbstractLoggingTestCase
{
    /**
     * @return void
     */
    public function testInstanceCreator(): void
    {
        $config = [
            'formatter' => [
                'app_name'       => null,
                'system_name'    => null,
                'extra_prefix'   => null,
                'context_prefix' => null,
                'version'        => null,
            ],
            'host'      => $host = '127.0.0.1',
            'port'      => $port = \random_int(100, 9999),
            'level'     => $level = 'error',
            'bubble'    => null,
            'silent'    => $silent = true,
        ];

        /** @var Logger $instance */
        $instance = (new EventsUdpLogstashLogger)($config);
        $this->assertInstanceOf(Logger::class, $instance);

        /** @var HandlerInterface|UdpHandler $handler */
        $handler = $instance->getHandlers()[0];
        $this->assertInstanceOf(UdpHandler::class, $handler);
        $this->assertSame($host, $handler->getHost());
        $this->assertSame($port, $handler->getPort());
        $this->assertSame(Logger::toMonologLevel($level), $handler->getLevel());

        $formatter = $handler->getFormatter();
        $this->assertInstanceOf(EventsLogstashFormatter::class, $formatter);
        $this->assertSame(\gethostname(), $this->getProperty($formatter, 'systemName'));
        $this->assertTrue($handler->getBubble());
        $this->assertSame($silent, $handler->isSilent());
        $this->assertSame(
            $this->app->make('config')->get('app.name'),
            $this->getProperty($formatter, 'applicationName')
        );
    }

    /**
     * @return void
     */
    public function testExceptionThrownWithUnsetHostname(): void
    {
        $this->expectException(InvalidArgumentException::class);

        (new EventsUdpLogstashLogger)([
            //'host' => '127.0.0.1',
            'port'   => \random_int(100, 9999),
            'level'  => null,
            'bubble' => null,
            'silent' => true,
        ]);
    }

    /**
     * @return void
     */
    public function testExceptionThrownWithUnsetPort(): void
    {
        $this->expectException(InvalidArgumentException::class);

        (new EventsUdpLogstashLogger)([
            'host'   => '127.0.0.1',
            //'port' => \random_int(100, 9999),
            'level'  => null,
            'bubble' => null,
            'silent' => true,
        ]);
    }
}
