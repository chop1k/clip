<?php

namespace Consolly\Tests\DataProvider\Event\Distributor;

use Consolly\Command\CommandInterface;

class CommandFoundSubscriberDataProvider
{
    public function __construct(protected CommandInterface $command)
    {
    }

    public function getArguments(): array
    {
        return [
            $this->command->getName()
        ];
    }
}
