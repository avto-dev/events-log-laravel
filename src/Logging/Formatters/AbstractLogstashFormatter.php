<?php

declare(strict_types = 1);

namespace AvtoDev\EventsLogLaravel\Logging\Formatters;

abstract class AbstractLogstashFormatter extends \Monolog\Formatter\LogstashFormatter
{
    /**
     * @param array<string, mixed> $record
     *
     * @return array<string, mixed>
     *
     * @see \Monolog\Formatter\LogstashFormatter::format
     */
    protected function formatRecord(array $record): array
    {
        $record = (array) parent::normalize($record);

        if (empty($record['datetime'])) {
            $record['datetime'] = gmdate('c');
        }
        $message = [
            '@timestamp' => $record['datetime'],
            '@version'   => 1,
            'host'       => $this->systemName,
        ];
        if (isset($record['message'])) {
            $message['message'] = $record['message'];
        }
        if (isset($record['channel'])) {
            $message['type']    = $record['channel'];
            $message['channel'] = $record['channel'];
        }
        if (isset($record['level_name'])) {
            $message['level'] = $record['level_name'];
        }
        if (isset($record['level'])) {
            $message['monolog_level'] = $record['level'];
        }
        if ($this->applicationName) {
            $message['type'] = $this->applicationName;
        }
        if (! empty($record['extra'])) {
            $message[$this->extraKey] = $record['extra'];
        }
        if (! empty($record['context'])) {
            $message[$this->contextKey] = $record['context'];
        }

        return $message;
    }
}
