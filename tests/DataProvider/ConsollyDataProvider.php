<?php

namespace Consolly\Tests\DataProvider;

use Consolly\Tests\Unit\ConsollyTest;

/**
 * Class ConsollyDataProvider represents data provider for {@link ConsollyTest} test.
 *
 * @package Consolly\Tests\DataProvider
 */
class ConsollyDataProvider
{
    /**
     * Returns data for {@link ConsollyTest::testDefaultCommand()} test.
     *
     * @return string[][][]
     */
    public function getDefaultCommandArguments(): array
    {
        return [
            [
                [
                    'unknown-command'
                ]
            ],
            [
                [
                    'unknown-command'
                ]
            ]
        ];
    }
}
