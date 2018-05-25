<?php

declare(strict_types = 1);

namespace AvtoDev\EventsLogLaravel;

use AvtoDev\EventsLogLaravel\Contracts\EventsSubscriberContract;
use AvtoDev\EventsLogLaravel\Listeners\EventsSubscriber;
use Illuminate\Config\Repository as ConfigRepository;
use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Log\LogManager;
use UnexpectedValueException;
use Illuminate\Events\Dispatcher;

class EventsLogServiceProvider extends ServiceProvider
{
    /**
     * Events logging channel name abstract.
     *
     * @var string
     */
    protected $channel_abstract = 'log.events.channel';

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
        /** @var Dispatcher $dispatcher */
        $dispatcher = $this->app->make('events');

        $dispatcher->subscribe($this->app->make(EventsSubscriberContract::class));
    }

    /**
     * Register events logging channel name.
     *
     * @throws UnexpectedValueException
     *
     * @return void
     */
    protected function registerChannel(): void
    {
        if (! $this->app->bound($this->channel_abstract)) {
            /** @var ConfigRepository $config */
            $config = $this->app->make('config');

            $channel_name = $config->get($config_key = 'logging.events_channel', env('EVENTS_LOG_CHANNEL'));

            if (! \is_string($channel_name) || empty($channel_name)) {
                throw new UnexpectedValueException("Missed config value [{$config_key}]");
            }

            $this->app->instance($this->channel_abstract, $channel_name);
        }
    }

    /**
     * Register event subscriber.
     *
     * @return void
     */
    protected function registerSubscriber(): void
    {
        $this->app->singleton(EventsSubscriberContract::class, function (Application $app) {
            return new EventsSubscriber($app->make(LogManager::class), $app->make($this->channel_abstract));
        });
    }
}
