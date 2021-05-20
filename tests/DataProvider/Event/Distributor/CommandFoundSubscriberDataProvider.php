<?php

namespace Consolly\Tests\DataProvider\Event\Distributor;

use Consolly\Command\CommandInterface;
use Consolly\Tests\Unit\Event\Distributor\CommandFoundSubscriberTest;

/**
 * Class CommandFoundSubscriberDataProvider represents data provider for {@link CommandFoundSubscriberTest} test.
 *
 * @package Consolly\Tests\DataProvider\Event\Distributor
 */
class CommandFoundSubscriberDataProvider
{
    /**
     * CommandFoundSubscriberDataProvider constructor.
     *
     * @param CommandInterface $command
     */
    public function __construct(protected CommandInterface $command)
    {
    }

    /**
     * Returns data for {@link CommandFoundSubscriberTest} test.
     *
     * @return string[]
     */
    public function getArguments(): array
    {
        return [
            $this->command->getName()
        ];
    }
}
