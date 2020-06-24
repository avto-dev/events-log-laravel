<?php

declare(strict_types = 1);

namespace AvtoDev\EventsLogLaravel\Listeners;

use Psr\Log\LoggerInterface;
use Illuminate\Log\LogManager;
use Illuminate\Contracts\Events\Dispatcher;
use AvtoDev\EventsLogLaravel\Contracts\ShouldBeLoggedContract;
use AvtoDev\EventsLogLaravel\Contracts\EventsSubscriberContract;

class EventsSubscriber implements EventsSubscriberContract
{
    /**
     * @var LoggerInterface
     */
    protected $log_driver;

    /**
     * Logger channel name, declared in `./config/logging.php['events_channel']`.
     *
     * @var string|null
     */
    protected $logger_channel_name;

    /**
     * Create a new EventsSubscriber instance.
     *
     * @param LogManager  $log_manager
     * @param string|null $logger_channel_name
     */
    public function __construct(LogManager $log_manager, ?string $logger_channel_name = null)
    {
        $this->logger_channel_name = $logger_channel_name;
        $this->log_driver          = $log_manager->driver($this->logger_channel_name);
    }

    /**
     * Returns logger.
     *
     * @return LoggerInterface
     */
    public function logDriver(): LoggerInterface
    {
        return $this->log_driver;
    }

    /**
     * All events listener.
     *
     * @param string|object        $event
     * @param array<string, mixed> $event_data
     *
     * @return void
     */
    public function onAnyEvents($event, array $event_data): void
    {
        $event_name = \is_string($event)
            ? $event
            : null;

        foreach ($event_data as $event_datum) {
            if (
                \is_object($event_datum)
                && $event_datum instanceof ShouldBeLoggedContract
                && $event_datum->skipLogging() === false
            ) {
                $this->writeEventIntoLog($event_datum, $event_name);
            }
        }
    }

    /**
     * Write event into log file.
     *
     * @param ShouldBeLoggedContract $event
     * @param string|null            $event_name
     *
     * @return void
     */
    public function writeEventIntoLog(ShouldBeLoggedContract $event, $event_name = null): void
    {
        $this->log_driver->log($event->logLevel(), $event->logMessage(), [
            'event' => \array_replace_recursive([
                'source' => $event->eventSource(),
                'type'   => $event->eventType(),
                'name'   => $event_name,
            ], $event->logEventExtraData()),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function subscribe(Dispatcher $events): void
    {
        $events->listen('*', function ($event, array $event_data) {
            $this->onAnyEvents($event, $event_data);
        });
    }
}
