<?php

declare(strict_types = 1);

namespace AvtoDev\EventsLogLaravel\Tests\Logging\Handlers;

use Monolog\Level;
use Illuminate\Support\Str;
use AvtoDev\EventsLogLaravel\Logging\Handlers\UdpHandler;
use AvtoDev\EventsLogLaravel\Tests\Logging\AbstractLoggingTestCase;

/**
 * @group handlers
 *
 * @covers \AvtoDev\EventsLogLaravel\Logging\Handlers\UdpHandler
 */
class UdpHandlerTest extends AbstractLoggingTestCase
{
    /**
     * @return void
     */
    public function testConstructor(): void
    {
        $handler = new UdpHandler(
            $host = Str::random(),
            $port = \random_int(100, 1000),
            $level = Level::Emergency,
            true,
            true
        );

        $this->assertSame($host, $handler->getHost());
        $this->assertSame($port, $handler->getPort());
        $this->assertSame($level, $handler->getLevel());
        $this->assertTrue($handler->getBubble());
        $this->assertTrue($handler->isSilent());
    }

    /**
     * @return void
     */
    public function testRecordToStringConvertWithFormattedKey(): void
    {
        $handler = new UdpHandler(
            Str::random(), 0, Level::Emergency, true, false
        );

        $log_record = $this->getLogRecord(
            level: Level::Info,
            message: 'Xtu94oGbN7vITLDGvF7eqNt9ff8uUcxh8mvsbyWb0z84YXWitZTJz5fj0VHrt8QJ',
            context: [
                'bar' => 'baz',
            ],
            channel: 'local',
        );

        $formatted = json_encode([
            '@timestamp' => '2019-04-11T06:50:01.145653+00:00',
            '@version' => 1,
            'host' => '6a5d4023606e',
            'message' => 'Xtu94oGbN7vITLDGvF7eqNt9ff8uUcxh8mvsbyWb0z84YXWitZTJz5fj0VHrt8QJ',
            'type' => 'app-name',
            'channel' => 'local',
            'level' => 'INFO',
            'bar' => 'baz'
        ]);
        $log_record->offsetSet('formatted', $formatted);;

        $this->assertSame($formatted, $handler->recordToString($log_record));
    }

    /**
     * @return void
     */
    public function testRecordToStringConvertWithoutFormattedKey(): void
    {
        $handler = new UdpHandler(
            Str::random(), 0, Level::Emergency, true, false
        );

        $log_record = $this->getLogRecord(
            level: Level::Info,
            message: 'Xtu94oGbN7vITLDGvF7eqNt9ff8uUcxh8mvsbyWb0z84YXWitZTJz5fj0VHrt8QJ',
            context: [
                'bar' => 'baz',
            ],
            channel: 'local',
        );

        $this->assertMatchesRegularExpression('~^ERROR.*formatter~i', $handler->recordToString($log_record));
    }
}
