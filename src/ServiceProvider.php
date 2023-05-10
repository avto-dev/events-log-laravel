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
            /** @var ConfigRepository $config */
            $config = $app->make(ConfigRepository::class);

            /** @var string $log_channel */
            $log_channel = $config->get('logging.events_channel', env('EVENTS_LOG_CHANNEL', 'default'));

            return $log_channel;
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
            /** @var LogManager $log_manager */
            $log_manager = $app->make(LogManager::class);

            /** @var string|null $log_channel */
            $log_channel = $app->make('log.events.channel');

            return new EventsSubscriber(
                $log_manager,
                $log_channel,
            );
        });
    }
}
