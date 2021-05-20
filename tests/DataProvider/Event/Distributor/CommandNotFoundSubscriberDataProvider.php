<?php

namespace Consolly\Tests\DataProvider\Event\Distributor;

use Consolly\Tests\Unit\Event\Distributor\CommandNotFoundSubscriberTest;

/**
 * Class CommandNotFoundSubscriberDataProvider represents data provider for {@link CommandNotFoundSubscriberTest} test.
 *
 * @package Consolly\Tests\DataProvider\Event\Distributor
 */
class CommandNotFoundSubscriberDataProvider
{
    /**
     * Returns data for {@link CommandNotFoundSubscriberTest} test.
     *
     * @return string[]
     */
    public function getArguments(): array
    {
        return [
            'unknown-command'
        ];
    }
}
