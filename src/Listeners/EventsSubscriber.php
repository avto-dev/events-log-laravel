<?php

declare(strict_types = 1);

namespace AvtoDev\EventsLogLaravel\Listeners;

use AvtoDev\EventsLogLaravel\Contracts\EventsSubscriberContract;
use AvtoDev\EventsLogLaravel\Contracts\ShouldBeLoggedContract;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Log\LogManager;
use Psr\Log\LoggerInterface;

class EventsSubscriber implements EventsSubscriberContract
{
    /**
     * @var LoggerInterface
     */
    protected $log_driver;

    /**
     * Logger channel name, declared in `./config/logging.php['events_channel']`.
     *
     * @var string
     */
    protected $logger_channel_name;

    /**
     * EventsLoggerSubscriber constructor.
     *
     * @param LogManager $log_manager
     * @param string     $logger_channel_name
     */
    public function __construct(LogManager $log_manager, string $logger_channel_name)
    {
        $this->logger_channel_name = $logger_channel_name;
        $this->log_driver          = $log_manager->driver($this->logger_channel_name);
    }

    /**
     * All events listener.
     *
     * @param mixed|string $event
     * @param array        $event_data
     *
     * @return void
     */
    public function onAnyEvents($event, array $event_data)
    {
        $event_name = \is_string($event)
            ? $event
            : null;

        foreach ($event_data as $event_datum) {
            if (\is_object($event_datum) && $event_datum instanceof ShouldBeLoggedContract) {
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
    public function writeEventIntoLog(ShouldBeLoggedContract $event, $event_name = null)
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
    public function subscribe(Dispatcher $events)
    {
        $events->listen('*', [$this, 'onAnyEvents']);
    }
}
