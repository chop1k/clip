<?php

namespace Consolly\Tests\DataProvider;

use Consolly\Tests\Command\DefaultTestCommand;

class ConsollyDataProvider
{
    public function getDefaultCommandArguments(): array
    {
        return [
            [
                [
                    'unknown-command'
                ], new DefaultTestCommand()
            ],
            [
                [
                    'unknown-command'
                ], new DefaultTestCommand()
            ]
        ];
    }
}
