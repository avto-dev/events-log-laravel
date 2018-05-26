<?php

namespace AvtoDev\EventsLogLaravel\Tests;

use UnexpectedValueException;
use AvtoDev\EventsLogLaravel\Listeners\EventsSubscriber;
use AvtoDev\EventsLogLaravel\Contracts\EventsSubscriberContract;

class EventsLogServiceProviderTest extends AbstractTestCase
{
    /**
     * Tests service-provider loading.
     *
     * @return void
     */
    public function testServiceProviderLoading()
    {
        /* @see AbstractTestCase::afterApplicationBootstrapped */
        $this->assertEquals('default', $this->app->make('log.events.channel'));

        $this->assertInstanceOf(EventsSubscriber::class, $this->app->make(EventsSubscriberContract::class));
    }

    /**
     * Test exception throws on invalid config.
     *
     * @return void
     */
    public function testExceptionThrowsOnInvalidConfig(): void
    {
        $this->expectException(UnexpectedValueException::class);
        $this->setup_default_channel = false;

        putenv('EVENTS_LOG_CHANNEL');

        $this->refreshApplication();
    }
}
