<?php

declare(strict_types = 1);

namespace AvtoDev\EventsLogLaravel\Logging\Traits;

use Illuminate\Container\Container;
use Illuminate\Contracts\Config\Repository;

trait AppNameTrait
{
    /**
     * Get application name.
     *
     * @return string|null
     */
    protected function getAppName(): ?string
    {
        try {
            return Container::getInstance()->make(Repository::class)->get('app.name');
        } catch (\Throwable $e) {
            return null;
        }
    }
}
