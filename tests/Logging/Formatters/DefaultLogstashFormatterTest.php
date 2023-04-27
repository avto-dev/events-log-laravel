<?php

declare(strict_types = 1);

namespace AvtoDev\EventsLogLaravel\Tests\Logging\Formatters;

use Illuminate\Support\Str;
use AvtoDev\EventsLogLaravel\Logging\Formatters\DefaultLogstashFormatter;

/**
 * @covers \AvtoDev\EventsLogLaravel\Logging\Formatters\DefaultLogstashFormatter
 */
class DefaultLogstashFormatterTest extends AbstractFormatterTestCase
{
    /**
     * @return void
     */
    public function testConstants(): void
    {
        $this->assertSame('log', DefaultLogstashFormatter::ENTRY_TYPE);
    }

    /**
     * @return void
     */
    public function testFormat(): void
    {
        $formatter = new DefaultLogstashFormatter(
            $app = Str::random(),
            $system = Str::random(),
            $extra = Str::random(),
            $context = Str::random()
        );

        $this->assertFormatterGeneratesCorrectJson($formatter, $app, $system, $extra, $context);

        $log_record = $this->getLogRecord(
            message: $message = Str::random(),
            context: $context_data = [Str::random()],
        );

        $as_array = \json_decode($formatter->format($log_record), true);

        $this->assertSame('log', $as_array['entry_type']);

        $this->assertSame($message, $as_array['message']);
        $this->assertSame($context_data, $as_array[$context]);
    }
}
