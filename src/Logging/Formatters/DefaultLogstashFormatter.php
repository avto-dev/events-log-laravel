<?php

declare(strict_types = 1);

namespace AvtoDev\EventsLogLaravel\Logging\Formatters;

class DefaultLogstashFormatter extends AbstractLogstashFormatter
{
    /**
     * Formats a log record.
     *
     * @param array<string, mixed> $record
     *
     * @return string
     */
    public function format(array $record): string
    {
        $formatted = $this->formatRecord($record);

        $formatted['entry_type'] = 'log';

        return $this->toJson($formatted) . "\n";
    }
}
