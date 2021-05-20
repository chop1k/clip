<?php

namespace Consolly\Tests\Unit;

use Consolly\Consolly;
use Consolly\Exception\CommandNotFoundException;
use Consolly\Tests\Command\DefaultTestCommand;
use Consolly\Tests\DataProvider\ConsollyDataProvider;
use PHPUnit\Framework\TestCase;
use Throwable;

/**
 * Class ConsollyTest represents test for {@link Consolly} class.
 *
 * @package Consolly\Tests\Unit
 */
class ConsollyTest extends TestCase
{
    /**
     * Data provider for the test.
     *
     * @var ConsollyDataProvider $dataProvider
     */
    protected ConsollyDataProvider $dataProvider;

    /**
     * @inheritDoc
     */
    public function __construct(?string $name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);

        $this->dataProvider = new ConsollyDataProvider();
    }

    /**
     * Returns dataset for testDefaultCommand test.
     *
     * @return string[][][]
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
     * @throws CommandNotFoundException|Throwable
     */
    public function testDefaultCommand(array $arguments): void
    {
        $commandExecuted = Consolly::default($arguments, new DefaultTestCommand())->handle();

        self::assertTrue($commandExecuted);
    }

    /**
     * Tests whether the exception throws when no command found.
     *
     * @throws CommandNotFoundException
     *
     * @throws Throwable
     */
    public function testCommandNotFound(): void
    {
        $this->expectException(CommandNotFoundException::class);

        Consolly::default([])->handle();
    }
}
