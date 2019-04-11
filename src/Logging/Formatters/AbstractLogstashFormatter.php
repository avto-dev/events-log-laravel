<?php

declare(strict_types = 1);

namespace AvtoDev\EventsLogLaravel\Logging\Formatters;

use Monolog\Formatter\LogstashFormatter;

abstract class AbstractLogstashFormatter extends LogstashFormatter
{
    /**
     * Format record for 'v0' format.
     *
     * @param array $record
     *
     * @return array Message
     */
    protected function formatV0(array $record)
    {
        return $this->modifyParentMessage(parent::formatV0($record), $record);
    }

    /**
     * Modify parent formatted message.
     *
     * @param array $parent_message
     * @param array $record
     *
     * @return array Message as an array
     */
    abstract protected function modifyParentMessage(array $parent_message, array $record): array;

    /**
     * Format record for 'v1' format.
     *
     * @param array $record
     *
     * @return array Message
     */
    protected function formatV1(array $record)
    {
        return $this->modifyParentMessage(parent::formatV1($record), $record);
    }
}
