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
            /** @var Repository $config_repository */
            $config_repository = Container::getInstance()->make(Repository::class);

            /** @var string|null $app_name */
            $app_name = $config_repository->get('app.name');

            return $app_name;
        } catch (\Throwable $e) {
            return null;
        }
    }
}
