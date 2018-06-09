<?php

namespace AvtoDev\EventsLogLaravel\Tests\Logging\Formatters;

use Monolog\Formatter\LogstashFormatter;
use AvtoDev\EventsLogLaravel\Logging\Formatters\EventsLogstashFormatter;

/**
 * @group logging
 */
class EventsLogstashFormatterTest extends AbstractLogstashFormatterTestCase
{
    /**
     * Тест метода-форматтера.
     */
    public function testFormatter(): void
    {
        foreach ([LogstashFormatter::V0, LogstashFormatter::V1] as $version) {
            $instance = new EventsLogstashFormatter(
                $app_name = 'test_app',
                $system_nme = null,
                $extra_prefix = 'extra_',
                $context_prefix = 'ctxt_',
                $version
            );

            $formatted = \json_decode($instance->format([
                'context' => [
                    'event' => [
                        'foo' => 'bar',
                    ],
                ],
            ]), true);

            $this->assertEquals('event', $formatted['entry_type']);
            $this->assertEquals('bar', $formatted[$extra_prefix . 'event']['foo']);
        }
    }
}
