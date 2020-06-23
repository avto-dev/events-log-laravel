<?php

declare(strict_types = 1);

namespace AvtoDev\EventsLogLaravel\Logging\Formatters;

class DefaultLogstashFormatter extends AbstractLogstashFormatter
{
    /**
     * {@inheritdoc}
     *
     * @return array<string, mixed> Message
     */
    protected function modifyParentMessage(array $parent_message, array $record): array
    {
        $parent_message['entry_type'] = 'log';

        return $parent_message;
    }
}
