<?php

declare(strict_types = 1);

namespace AvtoDev\EventsLogLaravel\Logging\Formatters;

final class EventsLogstashFormatter extends AbstractLogstashFormatter
{
    /**
     * Records entry type.
     */
    public const ENTRY_TYPE = 'event';

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

        if (isset($record['context']['event']) && \is_array($event_data = $record['context']['event'])) {
            $formatted[$this->extraKey . 'event'] = $event_data;
        }

        return $this->toJson($formatted) . "\n";
    }
}
