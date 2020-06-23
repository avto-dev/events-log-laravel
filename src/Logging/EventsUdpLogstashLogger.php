<?php

declare(strict_types = 1);

namespace AvtoDev\EventsLogLaravel\Logging;

use Exception;
use Monolog\Logger;
use InvalidArgumentException;
use Monolog\Formatter\LogstashFormatter;
use AvtoDev\EventsLogLaravel\Contracts\LoggerContract;
use AvtoDev\EventsLogLaravel\Logging\Formatters\EventsLogstashFormatter;

class EventsUdpLogstashLogger implements LoggerContract
{
    use Traits\AppNameTrait;

    /**
     * {@inheritdoc}
     *
     * @throws Exception
     */
    public function __invoke(array $config): Logger
    {
        if (! isset($config['host'], $config['port'])) {
            throw new InvalidArgumentException('[host] and [port] values are required for this logger');
        }

        $formatter = new EventsLogstashFormatter(
            $config['formatter']['app_name'] ?? $this->getAppName() ?? 'app',
            $config['formatter']['system_name'] ?? null,
            $config['formatter']['extra_prefix'] ?? 'extra',
            $config['formatter']['context_prefix'] ?? 'context'
        );

        $handler = new Handlers\UdpHandler(
            (string) $config['host'],
            (int) $config['port'],
            Logger::toMonologLevel($config['level'] ?? Logger::DEBUG), // The minimum logging level
            (bool) ($config['bubble'] ?? true), // Whether the messages that are handled can bubble up the stack or not
            (bool) ($config['silent'] ?? true)
        );

        return (new Logger($config['name'] ?? app()->environment()))
            ->pushHandler($handler->setFormatter($formatter));
    }
}
