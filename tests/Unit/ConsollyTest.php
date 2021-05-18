<?php

namespace Consolly\Tests\Unit;

use Consolly\Command\CommandInterface;
use Consolly\Consolly;
use Consolly\Exception\CommandNotFoundException;
use Consolly\Tests\DataProvider\ConsollyDataProvider;
use PHPUnit\Framework\TestCase;

/**
 * Class ConsollyTest represents test for {@link Consolly} class.
 *
 * @package Consolly\Tests
 */
class ConsollyTest extends TestCase
{
    protected ConsollyDataProvider $dataProvider;

    public function __construct(?string $name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);

        $this->dataProvider = new ConsollyDataProvider();
    }

    /**
     * Returns dataset for testDefaultCommand test.
     *
     * @return array[]
     */
    public function getDefaultCommandArguments(): array
    {
        return $this->dataProvider->getDefaultCommandArguments();
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
        $commandExecuted = Consolly::default($arguments, $defaultCommand)->handle();

        self::assertTrue($commandExecuted);
    }

    public function testCommandNotFound(): void
    {
        $this->expectException(CommandNotFoundException::class);

        Consolly::default([])->handle();
    }
}
