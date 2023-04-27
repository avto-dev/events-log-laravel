<?php

declare(strict_types = 1);

namespace AvtoDev\EventsLogLaravel\Tests\Events;

use AvtoDev\EventsLogLaravel\Tests\AbstractTestCase;
use AvtoDev\EventsLogLaravel\Events\AbstractLoggableEvent;
use AvtoDev\EventsLogLaravel\Contracts\ShouldBeLoggedContract;

/**
 * @covers \AvtoDev\EventsLogLaravel\Events\AbstractLoggableEvent
 */
class EventsTest extends AbstractTestCase
{
    /**
     * @return void
     */
    public function testEvents(): void
    {
        $instance = new class extends AbstractLoggableEvent {
            /**
             * {@inheritdoc}
             */
            public function logMessage(): string
            {
                return 'foo';
            }
        };

        $this->assertInstanceOf(ShouldBeLoggedContract::class, $instance);

        $this->assertEquals('info', $instance->logLevel());
        $this->assertEmpty($instance->logEventExtraData());
        $this->assertSame('UNKNOWN', $instance->eventType());
        $this->assertSame('UNKNOWN', $instance->eventSource());
    }
}
