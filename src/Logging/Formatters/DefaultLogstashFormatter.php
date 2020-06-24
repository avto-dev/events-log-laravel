<?php

declare(strict_types = 1);

namespace AvtoDev\EventsLogLaravel\Logging\Formatters;

final class DefaultLogstashFormatter extends AbstractLogstashFormatter
{
    /**
     * Records entry type.
     */
    public const ENTRY_TYPE = 'log';

    /**
     * Formats a log record.
     *
     * @param array<string, mixed> $record
     *
     * @return string
     */
    public function format(array $record): string
    {
        $formatted = $this->toLogstashFormat($record);

        $formatted['entry_type'] = self::ENTRY_TYPE;

        return $this->toJson($formatted) . "\n";
    }
}
