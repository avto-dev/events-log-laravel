<?php

declare(strict_types = 1);

namespace AvtoDev\EventsLogLaravel\Tests\Logging\Formatters;

use Monolog\Level;
use Illuminate\Support\Str;
use Monolog\DateTimeImmutable;
use Monolog\Formatter\FormatterInterface;
use AvtoDev\EventsLogLaravel\Tests\Logging\AbstractLoggingTestCase;

class AbstractFormatterTestCase extends AbstractLoggingTestCase
{
    /**
     * @param FormatterInterface $formatter
     * @param string             $app
     * @param string             $system
     * @param string             $extra
     * @param string             $context
     *
     * @return void
     */
    protected function assertFormatterGeneratesCorrectJson(
        FormatterInterface $formatter,
        string $app,
        string $system,
        string $extra,
        string $context
    ): void
    {
        $log_record = $this->getLogRecord(
            level: $level = Level::Debug,
            message: $message = Str::random(),
            context: $context_data = [Str::random()],
            channel: $channel = Str::random(),
            datetime: $datetime = new DateTimeImmutable(true),
            extra: $extra_data = [Str::random()],
        );

        $formatted_json = $formatter->format($log_record);

        $this->assertJson($formatted_json);
        $this->assertStringEndsWith("\n", $formatted_json);

        $as_array = \json_decode($formatted_json, true);

        $this->assertSame(1, $as_array['@version']);
        $this->assertSame($system, $as_array['host']);
        $this->assertSame($datetime->format('c'), $as_array['@timestamp']);
        $this->assertSame($app, $as_array['type']);

        $this->assertSame($message, $as_array['message']);
        $this->assertSame($channel, $as_array['channel']);
        $this->assertSame($level->value, $as_array['monolog_level']);
        $this->assertSame($level->getName(), $as_array['level']);
        $this->assertSame($extra_data, $as_array[$extra]);
        $this->assertSame($context_data, $as_array[$context]);
    }
}
