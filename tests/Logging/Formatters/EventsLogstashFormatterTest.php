<?php

namespace AvtoDev\EventsLogLaravel\Tests\Logging\Formatters;

use AvtoDev\EventsLogLaravel\Logging\Formatters\EventsLogstashFormatter;

/**
 * @group  logging
 *
 * @covers \AvtoDev\EventsLogLaravel\Logging\Formatters\EventsLogstashFormatter<extended>
 */
class EventsLogstashFormatterTest extends \AvtoDev\EventsLogLaravel\Tests\AbstractTestCase
{
    /**
     * Тест метода-форматтера.
     */
    public function testFormatter(): void
    {
        $instance = new EventsLogstashFormatter(
            $app_name = 'test_app',
            $system_nme = 'app',
            $extra_prefix = 'extra_',
            $context_prefix = 'ctxt_'
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
