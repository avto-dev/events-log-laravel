<?php

namespace AvtoDev\EventsLogLaravel\Contracts;

use Monolog\Logger;

interface LoggerContract
{
    /**
     * Create a Monolog instance.
     *
     * @param array $config
     *
     * @return Logger
     */
    public function __invoke(array $config): Logger;
}
