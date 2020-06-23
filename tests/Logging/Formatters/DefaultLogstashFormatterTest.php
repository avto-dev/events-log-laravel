<?php

namespace AvtoDev\EventsLogLaravel\Tests\Logging\Formatters;

use AvtoDev\EventsLogLaravel\Logging\Formatters\DefaultLogstashFormatter;

/**
 * @group  logging
 *
 * @covers \AvtoDev\EventsLogLaravel\Logging\Formatters\DefaultLogstashFormatter<extended>
 */
class DefaultLogstashFormatterTest extends \AvtoDev\EventsLogLaravel\Tests\AbstractTestCase
{
    /**
     * Тест метода-форматтера.
     */
    public function testFormatter(): void
    {
        $instance = new DefaultLogstashFormatter(
            'test_app',
            'name',
            'extra',
            'ctxt_'
        );

        $formatted = \json_decode($instance->format([]), true);

        $this->assertEquals('log', $formatted['entry_type']);
    }
}
