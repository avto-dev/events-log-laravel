<?php

declare(strict_types=1);

namespace AvtoDev\EventsLogLaravel\Logging;

use Exception;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Monolog\Formatter\LogstashFormatter;
use AvtoDev\EventsLogLaravel\Contracts\LoggerContract;
use AvtoDev\EventsLogLaravel\Logging\Formatters\DefaultLogstashFormatter;

class DefaultLogstashLogger implements LoggerContract
{
    /**
     * {@inheritdoc}
     *
     * @throws Exception
     */
    public function __invoke(array $config): Logger
    {
        $formatter = new DefaultLogstashFormatter(
            $config['formatter']['app_name'] ?? resolve('config')->get('app.name'),
            $config['formatter']['system_name'] ?? null,
            $config['formatter']['extra_prefix'] ?? false,
            $config['formatter']['context_prefix'] ?? null,
            $config['formatter']['version'] ?? LogstashFormatter::V1
        );

        $handler = new StreamHandler(
            $config['path'] ?? storage_path('logs/logstash/laravel.log'),
            $config['level'] ?? 'debug',
            $config['bubble'] ?? true,
            $config['permission'] ?? null,
            $config['locking'] ?? false
        );

        $name = $config['name'] ?? app()->environment();

        return (new Logger($name))->pushHandler($handler->setFormatter($formatter));
    }
}
