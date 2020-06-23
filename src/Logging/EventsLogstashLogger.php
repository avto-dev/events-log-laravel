<?php

declare(strict_types = 1);

namespace AvtoDev\EventsLogLaravel\Logging;

use Exception;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use AvtoDev\EventsLogLaravel\Contracts\LoggerContract;
use AvtoDev\EventsLogLaravel\Logging\Formatters\EventsLogstashFormatter;

class EventsLogstashLogger implements LoggerContract
{
    use Traits\AppNameTrait;

    /**
     * {@inheritdoc}
     *
     * @throws Exception
     */
    public function __invoke(array $config): Logger
    {
        $formatter = new EventsLogstashFormatter(
            $config['formatter']['app_name'] ?? $this->getAppName() ?? 'app',
            $config['formatter']['system_name'] ?? null,
            $config['formatter']['extra_prefix'] ?? 'extra',
            $config['formatter']['context_prefix'] ?? 'context'
        );

        $handler = new StreamHandler(
            $config['path'] ?? storage_path('logs/logstash/laravel-events.log'),
            Logger::toMonologLevel($config['level'] ?? Logger::DEBUG),
            (bool) ($config['bubble'] ?? true),
            $config['permission'] ?? null,
            (bool) ($config['locking'] ?? false)
        );

        $name = $config['name'] ?? app()->environment();

        return (new Logger($name))->pushHandler($handler->setFormatter($formatter));
    }
}
