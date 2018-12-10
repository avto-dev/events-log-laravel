<?php

declare(strict_types = 1);

namespace AvtoDev\EventsLogLaravel\Tests\Listeners\Stubs;

use Illuminate\Support\Str;

class LoggableEventSkipLoggingStub extends LoggableEventStub
{
    /**
     * @var bool
     */
    protected $skip_logging;

    /**
     * LoggableEventLogWhenStub constructor.
     *
     * @param bool $skip_logging
     */
    public function __construct(bool $skip_logging = true)
    {
        $this->skip_logging = $skip_logging;
    }

    /**
     * {@inheritdoc}
     */
    public function logMessage(): string
    {
        static $result = null;

        if ($result === null) {
            $result = Str::random(32);
        }

        return $result;
    }

    /**
     * @return bool
     */
    public function skipLogging(): bool
    {
        return $this->skip_logging;
    }
}
