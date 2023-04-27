<?php

declare(strict_types = 1);

namespace AvtoDev\EventsLogLaravel\Logging\Formatters;

use Monolog\LogRecord;

final class EventsLogstashFormatter extends AbstractLogstashFormatter
{
    /**
     * Records entry type.
     */
    public const ENTRY_TYPE = 'event';

    /**
     * Formats a log record.
     *
     * @param LogRecord $record
     *
     * @return string
     */
    public function format(LogRecord $record): string
    {
        $formatted = $this->toLogstashFormat($record);

        $formatted['entry_type'] = self::ENTRY_TYPE;

        $event_data = $record->context['event'] ?? null;

        if (\is_array($event_data)) {
            $formatted[$this->extraKey . 'event'] = $event_data;
        }

        return $this->toJson($formatted) . "\n";
    }
}
