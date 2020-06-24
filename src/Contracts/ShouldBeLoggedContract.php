<?php

declare(strict_types = 1);

namespace AvtoDev\EventsLogLaravel\Contracts;

interface ShouldBeLoggedContract
{
    /**
     * Log level. Can be one of: 'emergency', 'alert', 'critical', 'error', 'warning', 'notice', 'info', 'debug'.
     *
     * @return string
     */
    public function logLevel(): string;

    /**
     * Log message.
     *
     * @return string
     */
    public function logMessage(): string;

    /**
     * Log event extra data.
     *
     * @return array<string, mixed>
     */
    public function logEventExtraData(): array;

    /**
     * Event type (some type identifier).
     *
     * @return string
     */
    public function eventType(): string;

    /**
     * Event source (initiator of an event, service name).
     *
     * @return string
     */
    public function eventSource(): string;

    /**
     * Determine if this event should be skipped.
     *
     * @return bool
     */
    public function skipLogging(): bool;
}
