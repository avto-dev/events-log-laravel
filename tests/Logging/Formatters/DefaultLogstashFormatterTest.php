<?php

namespace AvtoDev\EventsLogLaravel\Tests\Logging\Formatters;

use Monolog\Formatter\LogstashFormatter;
use AvtoDev\EventsLogLaravel\Logging\Formatters\DefaultLogstashFormatter;

/**
 * @group logging
 */
class DefaultLogstashFormatterTest extends AbstractLogstashFormatterTestCase
{
    /**
     * Тест метода-форматтера.
     */
    public function testFormatter(): void
    {
        foreach ([LogstashFormatter::V0, LogstashFormatter::V1] as $version) {
            $instance = new DefaultLogstashFormatter(
                $app_name = 'test_app',
                $system_nme = null,
                $extra_prefix = null,
                $context_prefix = 'ctxt_',
                $version
            );

            $formatted = \json_decode($instance->format([]), true);

            $this->assertEquals('log', $formatted['entry_type']);
        }
    }
}
