<?php

namespace Consolly\Tests\DataProvider\Event\Distributor;

class CommandNotFoundSubscriberDataProvider
{
    public function getArguments(): array
    {
        return [
            'unknown-command'
        ];
    }
}
