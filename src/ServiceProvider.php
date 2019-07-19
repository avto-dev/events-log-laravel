<?php

declare(strict_types = 1);

namespace AvtoDev\EventsLogLaravel;

use Illuminate\Log\LogManager;
use Illuminate\Events\Dispatcher;
use Illuminate\Contracts\Container\Container;
use AvtoDev\EventsLogLaravel\Listeners\EventsSubscriber;
use Illuminate\Contracts\Config\Repository as ConfigRepository;
use AvtoDev\EventsLogLaravel\Contracts\EventsSubscriberContract;

class ServiceProvider extends \Illuminate\Support\ServiceProvider
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
     * @param Dispatcher               $events
     * @param EventsSubscriberContract $subscriber
     *
     * @return void
     */
    public function boot(Dispatcher $events, EventsSubscriberContract $subscriber): void
    {
        $events->subscribe($subscriber);
    }

    /**
     * Register events logging channel name.
     *
     * @return void
     */
    protected function registerChannel(): void
    {
        $this->app->bind('log.events.channel', function (Container $app): string {
            return $app
                ->make(ConfigRepository::class)
                ->get('logging.events_channel', env('EVENTS_LOG_CHANNEL', 'default'));
        });
    }

    /**
     * Register event subscriber.
     *
     * @return void
     */
    protected function registerSubscriber(): void
    {
        $this->app->bind(EventsSubscriberContract::class, function (Container $app): EventsSubscriberContract {
            return new EventsSubscriber(
                $app->make(LogManager::class),
                $app->make('log.events.channel')
            );
        });
    }
}
