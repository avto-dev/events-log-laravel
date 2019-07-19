<?php

namespace AvtoDev\EventsLogLaravel\Tests;

use AvtoDev\EventsLogLaravel\Listeners\EventsSubscriber;
use AvtoDev\EventsLogLaravel\Contracts\EventsSubscriberContract;

/**
 * @covers \AvtoDev\EventsLogLaravel\ServiceProvider<extended>
 */
class ServiceProviderTest extends AbstractTestCase
{
    /**
     * Tests service-provider loading.
     *
     * @return void
     */
    public function testServiceProviderLoading(): void
    {
        /* @see AbstractTestCase::afterApplicationBootstrapped */
        $this->assertEquals('default', $this->app->make('log.events.channel'));

        $this->assertInstanceOf(EventsSubscriber::class, $this->app->make(EventsSubscriberContract::class));
    }
}
