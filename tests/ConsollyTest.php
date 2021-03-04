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
                ], new DefaultTestCommand()
            ],
            [
                [
                    ''
                ], null
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
     * @throws CommandNotFoundException
     */
    public function testDefaultCommand(array $arguments, ?CommandInterface $defaultCommand): void
    {
        if (is_null($defaultCommand)) {
            $this->expectException(CommandNotFoundException::class);
        }

        $consolly = new Consolly(
            new ConsoleArgumentsSource($arguments, false),
            new Distributor(),
            $defaultCommand
        );

        $consolly->addCommand(new TestCommand());

        self::assertTrue($consolly->handle());
    }
}
