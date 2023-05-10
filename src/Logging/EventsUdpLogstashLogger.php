<?php

declare(strict_types = 1);

namespace AvtoDev\EventsLogLaravel\Logging;

use Exception;
use Monolog\Level;
use Monolog\Logger;
use InvalidArgumentException;
use Illuminate\Foundation\Application;
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
        /** @var string|null $host */
        $host = $config['host'] ?? null;

        /** @var numeric|null $port */
        $port = $config['port'] ?? null;

        if (! isset($host, $port)) {
            throw new InvalidArgumentException('[host] and [port] values are required for this logger');
        }

        /** @var array<string, string|null> $formatter_config */
        $formatter_config = $config['formatter'] ?? [];

        $formatter = new EventsLogstashFormatter(
            $formatter_config['app_name'] ?? $this->getAppName() ?? 'app',
            $formatter_config['system_name'] ?? null,
            $formatter_config['extra_prefix'] ?? 'extra',
            $formatter_config['context_prefix'] ?? 'context'
        );

        /** @var Level $log_level */
        $log_level = $config['level'] ?? Level::Debug;

        $handler = new Handlers\UdpHandler(
            (string) $host,
            (int) $port,
            Logger::toMonologLevel($log_level), // The minimum logging level
            (bool) ($config['bubble'] ?? true), // Whether the messages that are handled can bubble up the stack or not
            (bool) ($config['silent'] ?? true)
        );

        /** @var Application $app */
        $app = app();
        /** @var string $name */
        $name = $config['name'] ?? (string) $app->environment();

        return (new Logger($name))->pushHandler($handler->setFormatter($formatter));
    }
}
