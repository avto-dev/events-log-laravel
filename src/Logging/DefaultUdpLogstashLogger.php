<?php

declare(strict_types = 1);

namespace AvtoDev\EventsLogLaravel\Logging;

use Exception;
use Monolog\Logger;
use InvalidArgumentException;
use Monolog\Formatter\LogstashFormatter;
use AvtoDev\EventsLogLaravel\Contracts\LoggerContract;
use AvtoDev\EventsLogLaravel\Logging\Formatters\DefaultLogstashFormatter;

class DefaultUdpLogstashLogger implements LoggerContract
{
    /**
     * {@inheritdoc}
     *
     * @throws Exception
     */
    public function __invoke(array $config): Logger
    {
        if (! isset($config['host'], $config['port'])) {
            throw new InvalidArgumentException('[host] and [port] values is required for this logger');
        }

        try {
            $app_name = config()->get('app.name');
        } catch (\Throwable $e) {
            //
        }

        $formatter = new DefaultLogstashFormatter(
            $config['formatter']['app_name'] ?? $app_name ?? 'app',
            $config['formatter']['system_name'] ?? null,
            $config['formatter']['extra_prefix'] ?? false,
            $config['formatter']['context_prefix'] ?? null,
            $config['formatter']['version'] ?? LogstashFormatter::V1
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
