<?php

declare(strict_types = 1);

namespace AvtoDev\EventsLogLaravel\Logging\Traits;

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
            return config()->get('app.name');
        } catch (\Throwable $e) {
            //
        }

        return null;
    }
}
