<?php

declare(strict_types = 1);

namespace AvtoDev\EventsLogLaravel\Logging\Formatters;

use Monolog\LogRecord;

abstract class AbstractLogstashFormatter extends \Monolog\Formatter\LogstashFormatter
{
    /**
     * @param LogRecord $record
     *
     * @return array<string, mixed>
     *
     * @see \Monolog\Formatter\LogstashFormatter::format
     */
    protected function toLogstashFormat(LogRecord $record): array
    {
        $message = [
            '@timestamp'    => $record->datetime->format('c'),
            '@version'      => 1,
            'host'          => $this->systemName,
            'message'       => $record->message,
            'type'          => $record->channel,
            'channel'       => $record->channel,
            'level'         => $record->offsetGet('level_name'),
            'monolog_level' => $record->offsetGet('level'),
        ];

        if ($this->applicationName) {
            $message['type'] = $this->applicationName;
        }
        if (! empty($record->extra)) {
            $message[$this->extraKey] = $this->normalize($record->extra);
        }
        if (! empty($record->context)) {
            $message[$this->contextKey] = $this->normalize($record->context);
        }

        return $message;
    }
}
