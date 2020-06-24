<?php

declare(strict_types = 1);

namespace AvtoDev\EventsLogLaravel\Tests\Logging\Formatters;

use Illuminate\Support\Str;
use Monolog\Formatter\FormatterInterface;

class AbstractFormatterTestCase extends \AvtoDev\EventsLogLaravel\Tests\AbstractTestCase
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
    protected function assertFormatterGeneratesCorrectJson(FormatterInterface $formatter,
                                                           string $app,
                                                           string $system,
                                                           string $extra,
                                                           string $context): void
    {
        $formatted_json = $formatter->format([
            $key = Str::random() => \tmpfile(),
            'datetime'           => $datetime = \gmdate('c'),
            'message'            => $message = Str::random(),
            'channel'            => $channel = Str::random(),
            'level'              => $level = Str::random(),
            'level_name'         => $level_name = Str::random(),
            'extra'              => $extra_data = Str::random(),
            'context'            => $context_data = Str::random(),
        ]);

        $this->assertJson($formatted_json);
        $this->assertStringEndsWith("\n", $formatted_json);

        $as_array = \json_decode($formatted_json, true);

        $this->assertArrayNotHasKey($key, $as_array);
        $this->assertSame(1, $as_array['@version']);
        $this->assertSame($system, $as_array['host']);
        $this->assertSame($datetime, $as_array['@timestamp']);
        $this->assertSame($app, $as_array['type']);

        $this->assertSame($message, $as_array['message']);
        $this->assertSame($channel, $as_array['channel']);
        $this->assertSame($level, $as_array['monolog_level']);
        $this->assertSame($level_name, $as_array['level']);
        $this->assertSame($extra_data, $as_array[$extra]);
        $this->assertSame($context_data, $as_array[$context]);
    }
}
