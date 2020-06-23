<?php

declare(strict_types = 1);

namespace AvtoDev\EventsLogLaravel\Logging\Formatters;

class EventsLogstashFormatter extends AbstractLogstashFormatter
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

        $formatted['entry_type'] = 'event';

        if (isset($record['context']['event']) && \is_array($event_data = $record['context']['event'])) {
            $formatted[$this->extraKey . 'event'] = $event_data;
        }

        return $this->toJson($formatted) . "\n";
    }
}
