<?php

declare(strict_types = 1);

namespace AvtoDev\EventsLogLaravel\Logging\Formatters;

abstract class AbstractLogstashFormatter extends \Monolog\Formatter\LogstashFormatter
{
    /**
     * Format record for 'v0' format.
     *
     * @param array<string, mixed> $record
     *
     * @return array<string, mixed> Message
     */
    protected function formatV0(array $record): array
    {
        return $this->modifyParentMessage(parent::formatV0($record), $record);
    }

    /**
     * Modify parent formatted message.
     *
     * @param array<string, mixed> $parent_message
     * @param array<string, mixed> $record
     *
     * @return array<string, mixed> Message as an array
     */
    abstract protected function modifyParentMessage(array $parent_message, array $record): array;

    /**
     * Format record for 'v1' format.
     *
     * @param array<string, mixed> $record
     *
     * @return array<string, mixed> Message
     */
    protected function formatV1(array $record): array
    {
        return $this->modifyParentMessage(parent::formatV1($record), $record);
    }
}
