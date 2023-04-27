<?php

declare(strict_types = 1);

namespace AvtoDev\EventsLogLaravel\Logging;

use Exception;
use Monolog\Level;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Illuminate\Foundation\Application;
use AvtoDev\EventsLogLaravel\Contracts\LoggerContract;
use AvtoDev\EventsLogLaravel\Logging\Formatters\DefaultLogstashFormatter;

class DefaultLogstashLogger implements LoggerContract
{
    use Traits\AppNameTrait;

    /**
     * {@inheritdoc}
     *
     * @throws Exception
     */
    public function __invoke(array $config): Logger
    {
        /** @var array<string, string|null> $formatter_config */
        $formatter_config = $config['formatter'] ?? [];

        $formatter = new DefaultLogstashFormatter(
            $formatter_config['app_name'] ?? $this->getAppName() ?? 'app',
            $formatter_config['system_name'] ?? null,
            $formatter_config['extra_prefix'] ?? 'extra',
            $formatter_config['context_prefix'] ?? 'context'
        );

        /** @var resource|string|null $stream_path */
        $stream_path = $config['path'] ?? null;

        /** @var Level $log_level */
        $log_level = $config['level'] ?? Level::Debug;

        /** @var int|null $permission */
        $permission = $config['permission'] ?? null;

        $handler = new StreamHandler(
            $stream_path ?? storage_path('logs/logstash/laravel.log'),
            Logger::toMonologLevel($log_level),
            (bool) ($config['bubble'] ?? true),
            $permission,
            (bool) ($config['locking'] ?? false)
        );

        /** @var Application $app */
        $app = app();
        /** @var string $name */
        $name = $config['name'] ?? (string) $app->environment();

        return (new Logger($name))->pushHandler($handler->setFormatter($formatter));
    }
}
