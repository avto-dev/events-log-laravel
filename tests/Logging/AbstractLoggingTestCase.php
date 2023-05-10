<?php

declare(strict_types = 1);

namespace AvtoDev\EventsLogLaravel\Tests\Logging;

use Monolog\Level;
use Monolog\Logger;
use Monolog\LogRecord;
use Monolog\DateTimeImmutable;
use AvtoDev\EventsLogLaravel\Tests\AbstractTestCase;

class AbstractLoggingTestCase extends AbstractTestCase
{
    /**
     * @param array<string|int, mixed> $context
     * @param array<string|int, mixed> $extra
     *
     * @phpstan-param value-of<Level::VALUES>|value-of<Level::NAMES>|Level|LogLevel::* $level
     */
    protected function getLogRecord(
        int|string|Level $level = Level::Warning,
        string|\Stringable $message = 'test',
        array $context = [],
        string $channel = 'test',
        \DateTimeImmutable $datetime = new DateTimeImmutable(true),
        array $extra = []
    ): LogRecord
    {
        return new LogRecord(
            datetime: $datetime,
            channel: $channel,
            level: Logger::toMonologLevel($level),
            message: (string) $message,
            context: $context,
            extra: $extra,
        );
    }
}
