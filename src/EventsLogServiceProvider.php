<?php

declare(strict_types=1);

namespace AvtoDev\EventsLogLaravel;

use Illuminate\Log\LogManager;
use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Foundation\Application;
use AvtoDev\EventsLogLaravel\Listeners\EventsSubscriber;
use AvtoDev\EventsLogLaravel\Contracts\EventsSubscriberContract;

class EventsLogServiceProvider extends ServiceProvider
{
    /**
     * Register events logger.
     *
     * @return void
     */
    public function register(): void
    {
        $this->registerChannel();

        $this->registerSubscriber();
    }

    /**
     * Bootstrap events subscriber.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->make('events')->subscribe($this->app->make(EventsSubscriberContract::class));
    }

    /**
     * Register events logging channel name.
     *
     * @return void
     */
    protected function registerChannel(): void
    {
        $this->app->bind('log.events.channel', function (Application $app) {
            return $app->make('config')->get('logging.events_channel', env('EVENTS_LOG_CHANNEL'));
        });
    }

    /**
     * Register event subscriber.
     *
     * @return void
     */
    protected function registerSubscriber(): void
    {
        $this->app->bind(EventsSubscriberContract::class, function (Application $app): EventsSubscriberContract {
            return new EventsSubscriber(
                $app->make(LogManager::class),
                $app->make('log.events.channel')
            );
        });
    }
}
