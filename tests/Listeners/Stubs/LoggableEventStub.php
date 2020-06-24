<?php

namespace AvtoDev\EventsLogLaravel\Tests\Listeners\Stubs;

use AvtoDev\EventsLogLaravel\Contracts\ShouldBeLoggedContract;

class LoggableEventStub implements ShouldBeLoggedContract
{
    /**
     * {@inheritdoc}
     */
    public function logLevel(): string
    {
        return 'debug';
    }

    /**
     * {@inheritdoc}
     */
    public function logMessage(): string
    {
        return 'log message';
    }

    /**
     * {@inheritdoc}
     */
    public function logEventExtraData(): array
    {
        return ['foo' => 'bar'];
    }

    /**
     * {@inheritdoc}
     */
    public function eventType(): string
    {
        return 'event type';
    }

    /**
     * {@inheritdoc}
     */
    public function eventSource(): string
    {
        return 'event source';
    }

    /**
     * {@inheritdoc}
     */
    public function skipLogging(): bool
    {
        return false;
    }
}
