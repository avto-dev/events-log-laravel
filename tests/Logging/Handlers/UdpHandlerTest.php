<?php

declare(strict_types = 1);

namespace AvtoDev\EventsLogLaravel\Tests\Logging\Handlers;

use Monolog\Logger;
use Illuminate\Support\Str;
use AvtoDev\EventsLogLaravel\Tests\AbstractTestCase;
use AvtoDev\EventsLogLaravel\Logging\Handlers\UdpHandler;

/**
 * @group handlers
 *
 * @coversDefaultClass \AvtoDev\EventsLogLaravel\Logging\Handlers\UdpHandler
 */
class UdpHandlerTest extends AbstractTestCase
{
    /**
     * @return void
     */
    public function testConstructor(): void
    {
        $handler = new UdpHandler(
            $host = Str::random(),
            $port = \random_int(100, 1000),
            $level = Logger::EMERGENCY,
            $bubble = true,
            $silent = true
        );

        $this->assertSame($host, $handler->getHost());
        $this->assertSame($port, $handler->getPort());
        $this->assertSame($level, $handler->getLevel());
        $this->assertSame($bubble, $handler->getBubble());
        $this->assertSame($silent, $handler->isSilent());
    }

    /**
     * @return void
     */
    public function testRecordToStringConvertWithFormattedKey(): void
    {
        $handler = new UdpHandler(
            Str::random(), 0, Logger::EMERGENCY, true, false
        );

        $record = [
            'message'    => 'Xtu94oGbN7vITLDGvF7eqNt9ff8uUcxh8mvsbyWb0z84YXWitZTJz5fj0VHrt8QJ',
            'context'    => [
                'bar' => 'baz',
            ],
            'level'      => 200,
            'level_name' => 'INFO',
            'channel'    => 'local',
            'extra'      => [],
            'formatted'  => $formatted = '{"@timestamp":"2019-04-11T06:50:01.145653+00:00","@version":1,' .
                            '"host":"6a5d4023606e","message":"Xtu94oGbN7vITLDGvF7eqNt9ff8uUcxh8mvsbyWb0z84YXWitZ' .
                            'TJz5fj0VHrt8QJ","type":"app-name","channel":"local","level":"INFO","bar":"baz"}\n',
        ];

        $this->assertSame($formatted, $handler->recordToString($record));
    }

    /**
     * @return void
     */
    public function testRecordToStringConvertWithoutFormattedKey(): void
    {
        $handler = new UdpHandler(
            Str::random(), 0, Logger::EMERGENCY, true, false
        );

        $record = [
            'message'    => 'Xtu94oGbN7vITLDGvF7eqNt9ff8uUcxh8mvsbyWb0z84YXWitZTJz5fj0VHrt8QJ',
            'context'    => [
                'bar' => 'baz',
            ],
            'level'      => 200,
            'level_name' => 'INFO',
            'channel'    => 'local',
            'extra'      => [],
        ];

        $this->assertRegExp('~^ERROR.*formatter~i', $handler->recordToString($record));
    }
}
