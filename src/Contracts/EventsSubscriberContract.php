<?php

namespace AvtoDev\EventsLogLaravel\Contracts;

use Illuminate\Contracts\Events\Dispatcher;

interface EventsSubscriberContract
{
    /**
     * Register the listeners for the subscriber.
     *
     * @param Dispatcher $events
     *
     * @return void
     */
    public function subscribe(Dispatcher $events): void;
}
