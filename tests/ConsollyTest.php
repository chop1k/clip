<?php

namespace Consolly\Tests;

use Consolly\Command\CommandInterface;
use Consolly\Consolly;
use Consolly\Distributor\Distributor;
use Consolly\Exception\CommandNotFoundException;
use Consolly\Source\ConsoleArgumentsSource;
use Consolly\Tests\Command\DefaultTestCommand;
use Consolly\Tests\Command\TestCommand;
use PHPUnit\Framework\TestCase;

/**
 * Class ConsollyTest represents test for {@link Consolly} class.
 *
 * @package Consolly\Tests
 */
class ConsollyTest extends TestCase
{
    /**
     * Returns dataset for testDefaultCommand test.
     *
     * @return array[]
     */
    public function getDefaultCommandArguments(): array
    {
        return [
            [
                [
                    'unknown-command'
                ], new DefaultTestCommand(), true
            ],
            [
                [
                    'unknown-command'
                ], new DefaultTestCommand(), false
            ],
            [
                [
                    ''
                ], null, false
            ],
            [
                [
                ], new TestCommand(), false
            ],
            [
                [
                ], new TestCommand(), true
            ]
        ];
    }

    /**
     * Tests default command functionality of the {@link Consolly} class.
     *
     * @dataProvider getDefaultCommandArguments
     *
     * @param array $arguments
     *
     * @param CommandInterface|null $defaultCommand
     *
     * @param bool $addCommand
     *
     * @throws CommandNotFoundException
     */
    public function testDefaultCommand(array $arguments, ?CommandInterface $defaultCommand, bool $addCommand): void
    {
        if (is_null($defaultCommand)) {
            $this->expectException(CommandNotFoundException::class);
        }

        $consolly = new Consolly(
            new ConsoleArgumentsSource($arguments, false),
            new Distributor(),
            $defaultCommand
        );

        if ($addCommand) {
            $consolly->addCommand(new TestCommand());
        }

        self::assertTrue($consolly->handle());
    }
}
