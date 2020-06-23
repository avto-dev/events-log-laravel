<?php

declare(strict_types = 1);

namespace AvtoDev\EventsLogLaravel\Logging\Formatters;

class EventsLogstashFormatter extends AbstractLogstashFormatter
{
    /**
     * {@inheritdoc}
     *
     * @return array<string, mixed> Message
     */
    protected function modifyParentMessage(array $parent_message, array $record): array
    {
        $parent_message['entry_type'] = 'event';

        if (isset($record['context']['event']) && \is_array($event_data = $record['context']['event'])) {
            $parent_message[$this->extraPrefix . 'event'] = $event_data;
        }

        return $parent_message;
    }
}
