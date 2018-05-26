<?php

namespace AvtoDev\EventsLogLaravel\Tests\Events;

use AvtoDev\EventsLogLaravel\Tests\AbstractTestCase;
use AvtoDev\EventsLogLaravel\Events\AbstractLoggableEvent;
use AvtoDev\EventsLogLaravel\Contracts\ShouldBeLoggedContract;

class EventsTest extends AbstractTestCase
{
    /**
     * Test events.
     *
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

        $this->assertStringsEquals('info', $instance->logLevel(), false);
        $this->assertEmptyArray($instance->logEventExtraData());
        $this->assertStringsEquals('UNKNOWN', $instance->eventType(), false);
        $this->assertStringsEquals('UNKNOWN', $instance->eventSource(), false);
    }
}
