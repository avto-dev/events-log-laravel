<?php

declare(strict_types = 1);

namespace AvtoDev\EventsLogLaravel\Tests\Logging\Formatters;

use Illuminate\Support\Str;
use AvtoDev\EventsLogLaravel\Logging\Formatters\EventsLogstashFormatter;

/**
 * @covers \AvtoDev\EventsLogLaravel\Logging\Formatters\EventsLogstashFormatter<extended>
 */
class EventsLogstashFormatterTest extends AbstractFormatterTestCase
{
    /**
     * @return void
     */
    public function testConstants(): void
    {
        $this->assertSame('event', EventsLogstashFormatter::ENTRY_TYPE);
    }

    /**
     * @return void
     */
    public function testFormat(): void
    {
        $formatter = new EventsLogstashFormatter(
            $app = Str::random(),
            $system = Str::random(),
            $extra = Str::random(),
            $context = Str::random()
        );

        $this->assertFormatterGeneratesCorrectJson($formatter, $app, $system, $extra, $context);

        $as_array = \json_decode($formatter->format([
            'message' => $message = Str::random(),
            'context' => [
                'event' => $context_data = [Str::random(), Str::random()],
            ],
        ]), true);

        $this->assertSame('event', $as_array['entry_type']);
        $this->assertSame($message, $as_array['message']);

        $this->assertSame($message, $as_array['message']);
        $this->assertSame($context_data, $as_array[$extra . 'event']);
    }
}
