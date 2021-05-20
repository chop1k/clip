<?php

namespace Consolly\Tests\DataProvider\Event\Distributor;

use Consolly\Tests\Unit\Event\Distributor\CommandsSubscriberTest;

/**
 * Class CommandsSubscriberDataProvider represents data provider for {@link CommandsSubscriberTest} test.
 *
 * @package Consolly\Tests\DataProvider\Event\Distributor
 */
class CommandsSubscriberDataProvider
{
    /**
     * Returns data for {@link CommandsSubscriberTest} test.
     *
     * @return string[]
     */
    public function getArguments(): array
    {
        return [
            'default'
        ];
    }
}
